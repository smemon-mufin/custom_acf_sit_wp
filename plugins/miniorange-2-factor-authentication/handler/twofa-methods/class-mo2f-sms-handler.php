<?php
/**
 * This file is contains functions related to SMS method.
 *
 * @package miniOrange-2-factor-authentication/handler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use TwoFA\Onprem\MO2f_Cloud_Onprem_Interface;
use TwoFA\Helper\MoWpnsConstants;
use TwoFA\Onprem\Mo2f_Inline_Popup;
use TwoFA\Onprem\MO2f_Utility;
use TwoFA\Helper\Mo2f_Login_Popup;
use TwoFA\Helper\MoWpnsMessages;
use TwoFA\Onprem\Mo2f_Main_Handler;
use TwoFA\Helper\Mo2f_Common_Helper;
use TwoFA\Helper\TwoFAMoSessions;
if ( ! class_exists( 'Mo2f_SMS_Handler' ) ) {
	/**
	 * Class Mo2f_SMS_Handler
	 */
	class Mo2f_SMS_Handler {

		/**
		 * Current Method.
		 *
		 * @var string
		 */
		private $mo2f_current_method;

		/**
		 * Class Mo2f_SMS_Handler constructor
		 */
		public function __construct() {
			$this->mo2f_current_method = MoWpnsConstants::OTP_OVER_SMS;
		}



		/**
		 * Process Inline data for SMS.
		 *
		 * @param string $session_id Sessiong ID.
		 * @param string $redirect_to Redirection url.
		 * @param object $current_user_id Current user ID.
		 * @param string $mo2fa_login_message Login message.
		 * @return void
		 */
		public function mo2f_prompt_2fa_setup_inline( $session_id, $redirect_to, $current_user_id, $mo2fa_login_message ) {
			global $mo2f_onprem_cloud_obj;
			$current_user  = get_user_by( 'id', $current_user_id );
			$content       = $mo2f_onprem_cloud_obj->mo2f_set_user_two_fa( $current_user, $this->mo2f_current_method );
			$inline_helper = new Mo2f_Inline_Popup();
			$common_helper = new Mo2f_Common_Helper();
			$common_helper->mo2f_inline_css_and_js();
			$prev_screen = $common_helper->mo2f_get_previous_screen_for_inline( $current_user_id );
			$skeleton    = $common_helper->mo2f_sms_common_skeleton( $current_user_id );
			$html        = '<div class="mo2f_modal" tabindex="-1" role="dialog">
			<div class="mo2f-modal-backdrop"></div>
			<div class="mo_customer_validation-modal-dialog mo_customer_validation-modal-md">';
			$html       .= $common_helper->mo2f_otp_based_methods_configuration_screen( $skeleton, $this->mo2f_current_method, $content['mo2fa_login_message'], $current_user_id, $redirect_to, $session_id, $prev_screen );
			$html       .= '</div></div>';
			$html       .= $inline_helper->mo2f_get_inline_hidden_forms( $redirect_to, $session_id, $current_user->ID );
			$html       .= $common_helper->mo2f_get_script_for_otp_based_methods( 'inline' );
			echo $html;// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already escaped the necessary in the definition.
			exit;
		}

		/**
		 * Sends OTP to users phone.
		 *
		 * @param string $phone Phone number.
		 * @param string $session_id_encrypt Sessiond Id.
		 * @param object $user User.
		 * @param string $message message.
		 * @return void
		 */
		public function mo2f_send_otp( $phone, $session_id_encrypt, $user, $message ) {
			global $mo2f_onprem_cloud_obj, $mo2fdb_queries;
			$phone = $phone ?? $mo2fdb_queries->get_user_detail( 'mo2f_user_phone', $user->ID );
			TwoFAMoSessions::add_session_var( 'user_phone_temp', $phone );
			$content = json_decode( $mo2f_onprem_cloud_obj->send_otp_token( $phone, null, $this->mo2f_current_method, $user ), true );
			$this->mo2f_process_send_otp_content( $content, $session_id_encrypt, $user, $phone, $message );
		}

		/**
		 * Processes inline send otp.
		 *
		 * @param array  $content Content.
		 * @param string $session_id_encrypt Session id.
		 * @param object $user User.
		 * @param string $phone Phone.
		 * @param string $message message.
		 * @return void
		 */
		public function mo2f_process_send_otp_content( $content, $session_id_encrypt, $user, $phone, $message ) {
			if ( json_last_error() === JSON_ERROR_NONE ) { /* Generate otp token */
				if ( 'ERROR' === $content['status'] ) {
					wp_send_json_error( $content['message'] );
				} elseif ( MoWpnsConstants::SUCCESS_RESPONSE === $content['status'] ) {
					MO2f_Utility::mo2f_set_transient( $session_id_encrypt, 'mo2f_transactionId', $content['txId'] );
					TwoFAMoSessions::add_session_var( 'mo2f_transactionId', $content['txId'] );
					TwoFAMoSessions::add_session_var( 'mo2f_otp_send_true', true );
					$mo2f_sms = get_site_option( 'cmVtYWluaW5nT1RQVHJhbnNhY3Rpb25z' );
					if ( $mo2f_sms > 0 ) {
						update_site_option( 'cmVtYWluaW5nT1RQVHJhbnNhY3Rpb25z', $mo2f_sms - 1 );
					}
					wp_send_json_success( $message . ' ' . $phone . '. ' . MoWpnsMessages::lang_translate( MoWpnsMessages::ENTER_OTP ) . MoWpnsMessages::lang_translate( MoWpnsMessages::VERIFY_YOURSELF ) );
				} else {
					wp_send_json_error( MoWpnsMessages::lang_translate( MoWpnsMessages::GET_FREE_TRANSACTIONS ) );
				}
			} else {
				wp_send_json_error( MoWpnsMessages::lang_translate( MoWpnsMessages::INVALID_REQ ) );
			}
		}

		/**
		 * Validates OTP for SMS.
		 *
		 * @param string $otp_token OTP token.
		 * @param string $session_id_encrypt Transaction id.
		 * @param object $user Current user.
		 * @param object $prev_input Previous input.
		 * @param array  $post Post data.
		 * @return void
		 */
		public function mo2f_validate_otp( $otp_token, $session_id_encrypt, $user, $prev_input, $post ) {
			global $mo2f_onprem_cloud_obj;
			$user_phone = TwoFAMoSessions::get_session_var( 'user_phone_temp' );
			$this->mo2f_mismatch_input_check( $user_phone, $prev_input );
			$mo2f_transaction_id = MO2f_Utility::mo2f_get_transient( $session_id_encrypt, 'mo2f_transactionId' );
			$content             = json_decode( $mo2f_onprem_cloud_obj->validate_otp_token( $this->mo2f_current_method, null, $mo2f_transaction_id, $otp_token, $user ), true );
			$this->mo2f_process_validate_otp_content( $content, $user, $user_phone );
		}

		/**
		 * Process validate otp.
		 *
		 * @param array  $content Content.
		 * @param object $user User.
		 * @param string $user_phone User phone.
		 * @return void
		 */
		public function mo2f_process_validate_otp_content( $content, $user, $user_phone ) {
			if ( 'ERROR' === $content['status'] ) {
				wp_send_json_error( MoWpnsMessages::lang_translate( $content['message'] ) );
			} elseif ( strcasecmp( $content['status'], 'SUCCESS' ) === 0 ) {
				$email    = get_user_by( 'id', $user->ID )->user_email;
				$response = $this->mo2f_update_user_details( $user, $email, $user_phone );
				TwoFAMoSessions::unset_session( 'user_phone_temp' );
				TwoFAMoSessions::unset_session( 'mo2f_otp_send_true' );
				$this->mo2f_process_update_details_response( $response, $user );
			} else {  // OTP Validation failed.
				wp_send_json_error( MoWpnsMessages::lang_translate( MoWpnsMessages::INVALID_OTP ) );
			}
		}

		/**
		 * Processes update details.
		 *
		 * @param array  $response Response.
		 * @param object $user User.
		 * @return void
		 */
		public function mo2f_process_update_details_response( $response, $user ) {
			if ( json_last_error() === JSON_ERROR_NONE ) {
				if ( MoWpnsConstants::SUCCESS_RESPONSE === $response['status'] ) {
					wp_send_json_success( 'Your 2FA method has been set successfully.' );
				} else {
					wp_send_json_error( MoWpnsMessages::lang_translate( MoWpnsMessages::ERROR_DURING_PROCESS ) );
				}
			} else {
				wp_send_json_error( MoWpnsMessages::lang_translate( MoWpnsMessages::INVALID_REQ ) );
			}
		}

		/**
		 * Checks input mismatch.
		 *
		 * @param string $temp_phone Temp email.
		 * @param string $prev_input previously entered email.
		 * @return void
		 */
		public function mo2f_mismatch_input_check( $temp_phone, $prev_input ) {
			if ( $temp_phone !== $prev_input ) {
				wp_send_json_error( MoWpnsMessages::lang_translate( MoWpnsMessages::PHONE_NUMBER_MISMATCH ) );
			}
		}


		/**
		 * Updates GA details in database.
		 *
		 * @param object $user Current user.
		 * @param string $email Email.
		 * @param string $user_phone User phone.
		 * @return array
		 */
		public function mo2f_update_user_details( $user, $email, $user_phone ) {
			global $mo2f_onprem_cloud_obj;
			delete_user_meta( $user->ID, 'mo2f_user_profile_set' );
			return json_decode( $mo2f_onprem_cloud_obj->mo2f_update_user_info( $user->ID, true, $this->mo2f_current_method, MoWpnsConstants::SUCCESS_RESPONSE, MoWpnsConstants::MO_2_FACTOR_PLUGIN_SETTINGS, true, $email, $user_phone, 'API_2FA', true ), true );
		}

		/**
		 * Returns error message.
		 *
		 * @param object $currentuser Current user.
		 * @return string
		 */
		public function mo2f_get_error_message( $currentuser ) {
			if ( user_can( $currentuser->ID, 'administrator' ) ) {
				return MoWpnsMessages::GET_FREE_TRANSACTIONS;
			} else {
				return MoWpnsMessages::ERROR_DURING_PROCESS;
			}
		}

		/**
		 * Show SMS configuration prompt on dashboard.
		 *
		 * @return mixed
		 */
		public function mo2f_prompt_2fa_setup_dashboard() {
			global $mo2fdb_queries;
			$current_user = wp_get_current_user();
			$mo2fdb_queries->insert_user( $current_user->ID );
			$common_helper = new Mo2f_Common_Helper();
			if ( get_site_option( 'mo_2factor_admin_registration_status' ) === 'MO_2_FACTOR_CUSTOMER_REGISTERED_SUCCESS' ) {
				$skeleton = $common_helper->mo2f_sms_common_skeleton( $current_user->ID );
				$html     = $common_helper->mo2f_otp_based_methods_configuration_screen( $skeleton, $this->mo2f_current_method, '', $current_user->ID, '', '', 'dashboard' );
				$html    .= $this->mo2f_get_hidden_forms_dashboard( $common_helper );
				$html    .= $common_helper->mo2f_get_script_for_otp_based_methods( 'dashboard' );
			} else {
				$skeleton = array(
					'##crossbutton##'    => '	<button type="button" class="mo2f_close" data-dismiss="modal" aria-label="Close" title="' . esc_attr__( 'Back to login', 'miniorange-2-factor-authentication' ) . '" onclick="mologinback();">
					<span aria-hidden="true">&times;</span>
				</button>',
					'##miniorangelogo##' => $common_helper->mo2f_customize_logo(),
					'##pagetitle##'      => '<b>' . __( 'Login/Register with miniOrange', 'miniorange-2-factor-authentication' ) . '</b>',
				);
				$html     = '<div class="mo2f_login_register_popup">';
				$html    .= $common_helper->mo2f_get_miniorange_user_registration_prompt( '', null, null, 'dashboard', $skeleton );
				$html    .= '</div>';
			}
			wp_send_json_success( $html );
		}

		/**
		 * Show SMS Testing prompt on dashboard.
		 *
		 * @return mixed
		 */
		public function mo2f_prompt_2fa_test_dashboard() {
			global $mo2fdb_queries, $mo2f_onprem_cloud_obj, $mo_wpns_utility;
			$current_user    = wp_get_current_user();
			$mo2f_user_phone = $mo2fdb_queries->get_user_detail( 'mo2f_user_phone', $current_user->ID );
			$response        = json_decode( $mo2f_onprem_cloud_obj->send_otp_token( $mo2f_user_phone, null, $this->mo2f_current_method, $current_user ), true );
			if ( json_last_error() === JSON_ERROR_NONE ) {
				if ( 'SUCCESS' === $response['status'] ) {
					MO2f_Utility::mo2f_debug_file( 'OTP has been sent successfully over phone. User_IP-' . $mo_wpns_utility->get_client_ip() . ' User_Id-' . $current_user->ID . ' Email-' . $current_user->user_email );
					$mo2f_hidden_phone   = MO2f_Utility::get_hidden_phone( $mo2f_user_phone );
					$mo2fa_login_message = MoWpnsMessages::lang_translate( MoWpnsMessages::OTP_SENT ) . ' ' . $mo2f_hidden_phone . '. ' . MoWpnsMessages::lang_translate( MoWpnsMessages::ENTER_OTP ) . MoWpnsMessages::lang_translate( MoWpnsMessages::VERIFY_YOURSELF );
					$mo2fa_login_status  = MoWpnsConstants::MO_2_FACTOR_CHALLENGE_OTP_OVER_SMS;
					$common_helper       = new Mo2f_Common_Helper();
					TwoFAMoSessions::add_session_var( 'mo2f_transactionId', $response['txId'] );
					$login_popup     = new Mo2f_Login_Popup();
					$skeleton_values = $login_popup->mo2f_twofa_login_prompt_skeleton_values( $mo2fa_login_message, $mo2fa_login_status, null, null, $current_user->ID, 'test_2fa', '' );
					$html            = $login_popup->mo2f_get_twofa_skeleton_html( $mo2fa_login_status, $mo2fa_login_message, '', '', $skeleton_values, $this->mo2f_current_method, 'test_2fa' );
					$html           .= $login_popup->mo2f_get_validation_popup_script( 'test_2fa', $this->mo2f_current_method, '', '' );
					$html           .= $common_helper->mo2f_get_test_script();
					wp_send_json_success( $html );
				}
			}
			$mo2fa_login_message = $this->mo2f_get_error_message( $current_user );
			wp_send_json_error( $mo2fa_login_message );
		}

		/**
		 * Process login data for SMS.
		 *
		 * @param object $currentuser current user.
		 * @param string $session_id_encrypt Session ID.
		 * @param object $redirect_to Redirection url.
		 * @return void
		 */
		public function mo2f_prompt_2fa_login( $currentuser, $session_id_encrypt, $redirect_to ) {
			global $mo2fdb_queries, $mo2f_onprem_cloud_obj, $mo_wpns_utility;
			$mo2fa_login_message = $this->mo2f_get_error_message( $currentuser );
			$mo2fa_login_status  = MoWpnsConstants::MO2F_ERROR_MESSAGE_PROMPT;
			$mo2f_user_phone     = $mo2fdb_queries->get_user_detail( 'mo2f_user_phone', $currentuser->ID );
			$content             = json_decode( $mo2f_onprem_cloud_obj->send_otp_token( $mo2f_user_phone, null, $this->mo2f_current_method, $currentuser ), true );
			if ( json_last_error() === JSON_ERROR_NONE ) {
				if ( MoWpnsConstants::SUCCESS_RESPONSE === $content['status'] ) {
					$mo2f_hidden_phone   = MO2f_Utility::get_hidden_phone( $mo2f_user_phone );
					$mo2fa_login_message = MoWpnsMessages::lang_translate( MoWpnsMessages::OTP_SENT ) . ' ' . $mo2f_hidden_phone . '. ' . MoWpnsMessages::lang_translate( MoWpnsMessages::ENTER_OTP ) . MoWpnsMessages::lang_translate( MoWpnsMessages::VERIFY_YOURSELF );
					$mo2fa_login_status  = MoWpnsConstants::MO_2_FACTOR_CHALLENGE_OTP_OVER_SMS;
					TwoFAMoSessions::add_session_var( 'mo2f_transactionId', $content['txId'] );
					MO2f_Utility::mo2f_debug_file( $mo2fa_login_status . ' User_IP-' . $mo_wpns_utility->get_client_ip() . ' User_Id-' . $currentuser->ID . ' Email-' . $currentuser->user_email );
				}
			}
			$this->mo2f_show_login_prompt( $mo2fa_login_message, $mo2fa_login_status, $currentuser, $redirect_to, $session_id_encrypt );
			exit;
		}

		/**
		 * Show login popup for SMS.
		 *
		 * @param string $mo2fa_login_message Login message.
		 * @param string $mo2fa_login_status Login status.
		 * @param object $current_user Current user.
		 * @param string $redirect_to Redirection url.
		 * @param string $session_id_encrypt Session ID.
		 * @return void
		 */
		public function mo2f_show_login_prompt( $mo2fa_login_message, $mo2fa_login_status, $current_user, $redirect_to, $session_id_encrypt ) {
			$login_popup = new Mo2f_Login_Popup();
			$login_popup->mo2f_show_login_prompt_for_otp_based_methods( $mo2fa_login_message, $mo2fa_login_status, $current_user, $redirect_to, $session_id_encrypt, $this->mo2f_current_method );
			exit;
		}

		/**
		 * Validate otp at login.
		 *
		 * @param string $otp_token OTP token.
		 * @param string $redirect_to Redirection url.
		 * @param string $session_id_encrypt Session id.
		 * @return mixed
		 */
		public function mo2f_login_validate( $otp_token, $redirect_to, $session_id_encrypt ) {
			global $mo2f_onprem_cloud_obj, $mo2fdb_queries;
			$user_id = MO2f_Utility::mo2f_get_transient( $session_id_encrypt, 'mo2f_current_user_id' );
			if ( ! $user_id && is_user_logged_in() ) {
				$user    = wp_get_current_user();
				$user_id = $user->ID;
			}
			$current_user        = get_user_by( 'id', $user_id );
			$mo2f_transaction_id = TwoFAMoSessions::get_session_var( 'mo2f_transactionId' );
			$attempts            = TwoFAMoSessions::get_session_var( 'mo2f_attempts_before_redirect' );
			$content             = json_decode( $mo2f_onprem_cloud_obj->validate_otp_token( $this->mo2f_current_method, null, $mo2f_transaction_id, $otp_token, $current_user ), true );
			if ( 0 === strcasecmp( $content['status'], 'SUCCESS' ) ) {
				TwoFAMoSessions::add_session_var( 'mo2f_attempts_before_redirect', 3 );
				wp_send_json_success( 'VALIDATED_SUCCESS' );
			} else {
				if ( $attempts > 1 || 'disabled' === $attempts ) {
					TwoFAMoSessions::add_session_var( 'mo2f_attempts_before_redirect', $attempts - 1 );
					$mo2fa_login_message = MoWpnsMessages::INVALID_OTP;
					wp_send_json_error( 'INVALID_OTP' );
				} else {
					TwoFAMoSessions::unset_session( 'mo2f_attempts_before_redirect' );
					wp_send_json_error( 'LIMIT_EXCEEDED' );
				}
			}
		}

		/**
		 * Get hidden forms for dashboard.
		 *
		 * @param object $common_helper Common helper object.
		 * @return string
		 */
		public function mo2f_get_hidden_forms_dashboard( $common_helper ) {
			return $common_helper->mo2f_get_dashboard_hidden_forms();
		}

	}
	new Mo2f_SMS_Handler();
}

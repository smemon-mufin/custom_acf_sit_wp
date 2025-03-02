<?php
/**
 * This file contains functions related to login flow.
 *
 * @package miniorange-2-factor-authentication/controllers/twofa
 */

use TwoFA\Onprem\MO2f_Utility;
use TwoFA\Helper\MocURL;
use TwoFA\Helper\MoWpnsUtility;
use TwoFA\Helper\MoWpnsHandler;
use TwoFA\Onprem\MO2f_Cloud_Onprem_Interface;
use TwoFA\Onprem\Miniorange_Password_2Factor_Login;
use TwoFA\Helper\MoWpnsConstants;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * This function redirect user to given url.
 *
 * @param object $user object containing user details.
 * @param string $redirect_to redirect url.
 * @return void
 */
function redirect_user_to( $user, $redirect_to ) {
	$roles        = $user->roles;
	$current_role = array_shift( $roles );
	$redirect_to  = get_option( 'mo2f_custom_redirect_url' ) ? get_option( 'mo2f_custom_redirect_url' ) : $redirect_to;
	if ( is_multisite() ) {
		$blog_id = get_current_blog_id();
		if ( is_super_admin( $user->ID ) ) {

			$redirect_url = isset( $redirect_to ) && ! empty( $redirect_to ) ? $redirect_to : admin_url();

		} elseif ( 'administrator' === $current_role ) {

			$redirect_url = empty( $redirect_to ) ? admin_url() : $redirect_to;

		} else {

			$redirect_url = empty( $redirect_to ) ? home_url() : $redirect_to;
		}
	} else {
		if ( 'administrator' === $current_role ) {
			$redirect_url = empty( $redirect_to ) ? admin_url() : $redirect_to;
		} else {
			$redirect_url = empty( $redirect_to ) ? home_url() : $redirect_to;
		}
	}
	if ( MO2f_Utility::get_index_value( 'GLOBALS', 'mo2f_is_ajax_request' ) ) {
		$redirect = array(
			'redirect' => $redirect_url,
		);
		wp_send_json_success( $redirect );
	} else {
		wp_safe_redirect( $redirect_url ); // Use wp_redirect() for local testing.
		exit();
	}
}

/**
 * Function checks if 2fa enabled for given user roles (used in shortcode addon)
 *
 * @param array $current_roles array containing roles of user.
 * @return boolean
 */
function miniorange_check_if_2fa_enabled_for_roles( $current_roles ) {
	if ( empty( $current_roles ) ) {
		return 0;
	}

	foreach ( $current_roles as $value ) {
		if ( get_option( 'mo2fa_' . $value ) ) {
			return 1;
		}
	}

	return 0;
}

/**
 * This function prompts forgot phone form.
 *
 * @param string $login_status login status of user.
 * @param string $login_message message used to show success/failed login actions.
 * @param string $redirect_to redirect url.
 * @param string $session_id_encrypt encrypted session id.
 * @return void
 */
function mo2f_get_forgotphone_form( $login_status, $login_message, $redirect_to, $session_id_encrypt ) {
	$mo2f_forgotphone_enabled     = MoWpnsUtility::get_mo2f_db_option( 'mo2f_enable_forgotphone', 'get_option' );
	$mo2f_email_as_backup_enabled = get_option( 'mo2f_enable_forgotphone_email' );
	$mo2f_kba_as_backup_enabled   = get_option( 'mo2f_enable_forgotphone_kba' );
	?>
	<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php
		echo_js_css_files();
		?>
	</head>
	<body>
	<div class="mo2f_modal" tabindex="-1" role="dialog">
		<div class="mo2f-modal-backdrop"></div>
		<div class="mo_customer_validation-modal-dialog mo_customer_validation-modal-md">
			<div class="login mo_customer_validation-modal-content">
				<div class="mo2f_modal-header">
					<h4 class="mo2f_modal-title">
						<button type="button" class="mo2f_close" data-dismiss="modal" aria-label="Close"
								title="<?php esc_attr_e( 'Back to login', 'miniorange-2-factor-authentication' ); ?>"
								onclick="mologinback();"><span aria-hidden="true">&times;</span></button>
						<?php esc_html_e( 'How would you like to authenticate yourself?', 'miniorange-2-factor-authentication' ); ?>
					</h4>
				</div>
				<div class="mo2f_modal-body">
					<?php
					if ( $mo2f_forgotphone_enabled ) {
						if ( isset( $login_message ) && ! empty( $login_message ) ) {
							?>
							<div id="otpMessage" class="mo2fa_display_message_frontend">
								<p class="mo2fa_display_message_frontend"><?php echo wp_kses( $login_message, array( 'b' => array() ) ); ?></p>
							</div>
						<?php } ?>
						<p class="mo2f_backup_options"><?php esc_html_e( 'Please choose the options from below:', 'miniorange-2-factor-authentication' ); ?></p>
						<div class="mo2f_backup_options_div">
							<?php if ( $mo2f_email_as_backup_enabled ) { ?>
								<input type="radio" name="mo2f_selected_forgotphone_option"
									value="One Time Passcode over Email"
									checked="checked"/><?php esc_html_e( 'Send a one time passcode to my registered email', 'miniorange-2-factor-authentication' ); ?>
								<br><br>
								<?php
							}
							if ( $mo2f_kba_as_backup_enabled ) {
								?>
								<input type="radio" name="mo2f_selected_forgotphone_option"
									value="'<?php echo esc_js( MoWpnsConstants::SECURITY_QUESTIONS ); ?>'"/><?php esc_html_e( 'Answer your Security Questions (KBA)', 'miniorange-2-factor-authentication' ); ?>
							<?php } ?>
							<br><br>
							<input type="button" name="miniorange_validate_otp" value="<?php esc_attr_e( 'Continue', 'miniorange-2-factor-authentication' ); ?>" class="miniorange_validate_otp"
								onclick="mo2fselectforgotphoneoption();"/>
						</div>
						<?php
						mo2f_customize_logo();
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<form name="f" id="mo2f_backto_mo_loginform" method="post" action="<?php echo esc_url( wp_login_url() ); ?>"
		class="mo2f_display_none_forms">
		<input type="hidden" name="miniorange_mobile_validation_failed_nonce"
			value="<?php echo esc_attr( wp_create_nonce( 'miniorange-2-factor-mobile-validation-failed-nonce' ) ); ?>"/>
		<input type="hidden" name="redirect_to" value="<?php echo esc_url( $redirect_to ); ?>"/>
		<input type="hidden" name="session_id" value="<?php echo esc_attr( $session_id_encrypt ); ?>"/>
	</form>
	<form name="f" id="mo2f_challenge_forgotphone_form" method="post" class="mo2f_display_none_forms">
		<input type="hidden" name="mo2f_configured_2FA_method"/>
		<input type="hidden" name="miniorange_challenge_forgotphone_nonce"
			value="<?php echo esc_attr( wp_create_nonce( 'miniorange-2-factor-challenge-forgotphone-nonce' ) ); ?>"/>
		<input type="hidden" name="option" value="miniorange_challenge_forgotphone">
		<input type="hidden" name="redirect_to" value="<?php echo esc_url( $redirect_to ); ?>"/>
		<input type="hidden" name="session_id" value="<?php echo esc_attr( $session_id_encrypt ); ?>"/>
	</form>

	<script>
		function mologinback() {
			jQuery('#mo2f_backto_mo_loginform').submit();
		}

		function mo2fselectforgotphoneoption() {
			var option = jQuery('input[name=mo2f_selected_forgotphone_option]:checked').val();
			document.getElementById("mo2f_challenge_forgotphone_form").elements[0].value = option;
			jQuery('#mo2f_challenge_forgotphone_form').submit();
		}
	</script>
	</body>
	</html>
	<?php
}


/**
 * This function prompts duo authentication
 *
 * @param string $login_status login status of user.
 * @param string $login_message message used to show success/failed login actions.
 * @param string $redirect_to redirect url.
 * @param string $session_id_encrypt encrypted session id.
 * @param string $user_id user id.
 * @return void
 */
function mo2f_get_duo_push_authentication_prompt( $login_status, $login_message, $redirect_to, $session_id_encrypt, $user_id ) {

	$mo_wpns_config = new MO2f_Cloud_Onprem_Interface();

	global $mo2fdb_queries,$txid,$mo_wpns_utility;
	$mo2f_enable_forgotphone = MoWpnsUtility::get_mo2f_db_option( 'mo2f_enable_forgotphone', 'get_option' );
	$mo2f_kba_config_status  = $mo2fdb_queries->get_user_detail( 'mo2f_SecurityQuestions_config_status', $user_id );
	$mo2f_ev_txid            = get_user_meta( $user_id, 'mo2f_transactionId', true );
	$user_id                 = MO2f_Utility::mo2f_get_transient( $session_id_encrypt, 'mo2f_current_user_id' );

	$current_user = get_user_by( 'id', $user_id );
	MO2f_Utility::mo2f_debug_file( 'Waiting for duo push notification validation User_IP-' . $mo_wpns_utility->get_client_ip() . ' User_Id-' . $current_user->ID . ' Email-' . $current_user->user_email );
	update_user_meta( $user_id, 'current_user_email', $current_user->user_email );

	?>

	<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php
			echo_js_css_files();
		?>
	</head>
	<body>
	<div class="mo2f_modal" tabindex="-1" role="dialog">
		<div class="mo2f-modal-backdrop"></div>
		<div class="mo_customer_validation-modal-dialog mo_customer_validation-modal-md">
			<div class="login mo_customer_validation-modal-content">
				<div class="mo2f_modal-header">
					<h4 class="mo2f_modal-title">
						<button type="button" class="mo2f_close" data-dismiss="modal" aria-label="Close"
								title="<?php esc_attr_e( 'Back to login', 'miniorange-2-factor-authentication' ); ?>"
								onclick="mologinback();"><span aria-hidden="true">&times;</span></button>
						<?php esc_html_e( 'Accept Your Transaction', 'miniorange-2-factor-authentication' ); ?></h4>
				</div>
				<div class="mo2f_modal-body">
					<?php if ( isset( $login_message ) && ! empty( $login_message ) ) { ?>
						<div id="otpMessage">
							<p class="mo2fa_display_message_frontend"><?php echo wp_kses( $login_message, array( 'b' => array() ) ); ?></p>
						</div>
					<?php } ?>
					<div id="pushSection">

						<div>
							<div class="mo2fa_text-align-center">
								<p class="mo2f_push_oob_message"><?php esc_html_e( 'Waiting for your approval...', 'miniorange-2-factor-authentication' ); ?></p>
					</div>
						</div>
						<div id="showPushImage">
							<div class="mo2fa_text-align-center">
								<img src="<?php echo esc_url( plugins_url( 'includes/images/ajax-loader-login.gif', dirname( dirname( __FILE__ ) ) ) ); ?>"/>
					</div>
						</div>


						<span style="padding-right:2%;">
							<?php if ( isset( $login_status ) && 'MO_2_FACTOR_CHALLENGE_PUSH_NOTIFICATIONS' === $login_status ) { ?>
								<div class="mo2fa_text-align-center">
									&emsp;&emsp;
									</div>
							<?php } elseif ( isset( $login_status ) && MoWpnsConstants::MO_2_FACTOR_CHALLENGE_OOB_EMAIL === $login_status && $mo2f_enable_forgotphone && $mo2f_kba_config_status ) { ?>
								<div class="mo2fa_text-align-center">
								<a href="#mo2f_alternate_login_kba">
									<p class="mo2f_push_oob_backup"><?php esc_html_e( 'Didn\'t receive push nitification?', 'miniorange-2-factor-authentication' ); ?></p>
								</a>
							</div>
							<?php } ?>
						</span>
						<div class="mo2fa_text-align-center">
							<?php
							if ( empty( get_user_meta( $user_id, 'mo_backup_code_generated', true ) ) ) {
								?>
									<div>
										<a href="#mo2f_backup_generate">
											<p style="font-size:14px; font-weight:bold;"><?php esc_html_e( 'Send backup codes on email', 'miniorange-2-factor-authentication' ); ?></p>
										</a>
									</div>
							<?php } else { ?>
									<div>
										<a href="#mo2f_backup_option">
											<p style="font-size:14px; font-weight:bold;"><?php esc_html_e( 'Use Backup Codes', 'miniorange-2-factor-authentication' ); ?></p>
										</a>
									</div>
								<?php
							}
							?>
							<div style="padding:10px;">
								<p><a href="<?php echo esc_url( $mo_wpns_config->locked_out_link() ); ?>" target="_blank" style="color:#ca2963;font-weight:bold;">I'm locked out & unable to login.</a></p>
							</div>
						</div>
					</div>

					<?php
						mo2f_customize_logo();
						mo2f_create_backup_form( $redirect_to, $session_id_encrypt, $login_status, $login_message );
					?>
				</div>
			</div>
		</div>
	</div>
	<form name="f" id="mo2f_backto_duo_mo_loginform" method="post" action="<?php echo esc_url( wp_login_url() ); ?>"
			class="mo2f_display_none_forms">
		<input type="hidden" name="miniorange_duo_push_validation_failed_nonce"
				value="<?php echo esc_attr( wp_create_nonce( 'miniorange-2-factor-duo-push-validation-failed-nonce' ) ); ?>"/>
		<input type="hidden" name="option" value="miniorange_duo_push_validation_failed">
		<input type="hidden" name="redirect_to" value="<?php echo esc_url( $redirect_to ); ?>"/>
		<input type="hidden" name="session_id" value="<?php echo esc_attr( $session_id_encrypt ); ?>"/>
		<input type="hidden" name="currentMethod" value="emailVer"/>
	</form>
	<form name="f" id="mo2f_duo_push_validation_form" method="post" class="mo2f_display_none_forms">
		<input type="hidden" name="miniorange_duo_push_validation_nonce"
				value="<?php echo esc_attr( wp_create_nonce( 'miniorange-2-factor-duo-validation-nonce' ) ); ?>"/>
		<input type="hidden" name="option" value="miniorange_duo_push_validation">
		<input type="hidden" name="redirect_to" value="<?php echo esc_url( $redirect_to ); ?>"/>
		<input type="hidden" name="tx_type"/>
		<input type="hidden" name="session_id" value="<?php echo esc_attr( $session_id_encrypt ); ?>"/>
		<input type="hidden" name="TxidEmail" value="<?php echo esc_attr( $mo2f_ev_txid ); ?>"/>
	</form>
	<form name="f" id="mo2f_show_forgotphone_loginform" method="post" class="mo2f_display_none_forms">
		<input type="hidden" name="request_origin_method" value="<?php echo esc_attr( $login_status ); ?>"/>
		<input type="hidden" name="miniorange_forgotphone" value="<?php echo esc_attr( wp_create_nonce( 'miniorange-2-factor-forgotphone' ) ); ?>"/>
		<input type="hidden" name="option" value="miniorange_forgotphone">
		<input type="hidden" name="redirect_to" value="<?php echo esc_url( $redirect_to ); ?>"/>
		<input type="hidden" name="session_id" value="<?php echo esc_attr( $session_id_encrypt ); ?>"/>
	</form>
	<form name="f" id="mo2f_alternate_login_kbaform" method="post" class="mo2f_display_none_forms">
		<input type="hidden" name="miniorange_alternate_login_kba_nonce"
				value="<?php echo esc_attr( wp_create_nonce( 'miniorange-2-factor-alternate-login-kba-nonce' ) ); ?>"/>
		<input type="hidden" name="option" value="miniorange_alternate_login_kba">
		<input type="hidden" name="redirect_to" value="<?php echo esc_url( $redirect_to ); ?>"/>
		<input type="hidden" name="session_id" value="<?php echo esc_attr( $session_id_encrypt ); ?>"/>
	</form>

	<script>
		var timeout;

			pollPushValidation();
			function pollPushValidation()
			{   
				var ajax_url = "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"; 
				var nonce = "<?php echo esc_js( wp_create_nonce( 'miniorange-2-factor-duo-nonce' ) ); ?>";
				var session_id_encrypt = "<?php echo esc_js( $session_id_encrypt ); ?>";
				var data={
					'action':'mo2f_duo_ajax_request',
					'call_type':'check_duo_push_auth_status',
					'session_id_encrypt': session_id_encrypt,
					'nonce' : nonce,
				}; 

				jQuery.post(ajax_url, data, function(response){


							if (response.success) {
								jQuery('#mo2f_duo_push_validation_form').submit();
							} else if (response.data == 'ERROR' || response.data == 'FAILED' || response.data == 'DENIED' || response.data ==0) {
								jQuery('#mo2f_backto_duo_mo_loginform').submit();
							} else {
								timeout = setTimeout(pollMobileValidation, 3000);
							}
				});
		}

		function mologinforgotphone() {
			jQuery('#mo2f_show_forgotphone_loginform').submit();
		}

		function mologinback() {
			jQuery('#mo2f_backto_duo_mo_loginform').submit();
		}

		jQuery('a[href="#mo2f_alternate_login_kba"]').click(function () {
			jQuery('#mo2f_alternate_login_kbaform').submit();
		});
		jQuery('a[href="#mo2f_backup_option"]').click(function() {
			jQuery('#mo2f_backup').submit();
		});
		jQuery('a[href="#mo2f_backup_generate"]').click(function() {
			jQuery('#mo2f_create_backup_codes').submit();
		});

	</script>
	</body>
	</html>

	<?php
}



/**
 * This function prints customized logo.
 *
 * @return string
 */
function mo2f_customize_logo() {
	$html = '<div style="float:right;"><img
					alt="logo"
					src="' . esc_url( plugins_url( 'includes/images/miniOrange2.png', dirname( __FILE__ ) ) ) . '"/></div>';
					return $html;

}

/**
 * This function used to include css and js files.
 *
 * @return void
 */
function echo_js_css_files() {
	wp_register_style( 'mo2f_style_settings', plugins_url( 'includes/css/twofa_style_settings.min.css', dirname( __FILE__ ) ), array(), MO2F_VERSION );
	wp_print_styles( 'mo2f_style_settings' );

	wp_register_script( 'mo2f_bootstrap_js', plugins_url( 'includes/js/bootstrap.min.js', dirname( __FILE__ ) ), array(), MO2F_VERSION, true );
	wp_print_scripts( 'jquery' );
	wp_print_scripts( 'mo2f_bootstrap_js' );
}

/**
 * Creates and sends backupcodes.
 *
 * @param string $session_id_encrypt Session Id.
 * @return array
 */
function mo2f_create_and_send_backupcodes_inline( $session_id_encrypt ) {

	global $mo2fdb_queries;
	$id = MO2f_Utility::mo2f_get_transient( $session_id_encrypt, 'mo2f_current_user_id' );
	update_site_option( 'mo2f_is_inline_used', '1' );
	$mo2f_user_email = $mo2fdb_queries->get_user_detail( 'mo2f_user_email', $id );
	if ( empty( $mo2f_user_email ) ) {
		$currentuser     = get_user_by( 'id', $id );
		$mo2f_user_email = $currentuser->user_email;
	}
	$generate_backup_code = new MocURL();
	$codes                = $generate_backup_code->mo_2f_generate_backup_codes( $mo2f_user_email, site_url() );
	$codes                = explode( ' ', $codes );
	$result               = MO2f_Utility::mo2f_email_backup_codes( $codes, $mo2f_user_email );
	update_user_meta( $id, 'mo_backup_code_generated', 1 );
	update_user_meta( $id, 'mo_backup_code_screen_shown', 1 );
	return $codes;
}

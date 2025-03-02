<?php
/**
 * This file shows the plugin settings on frontend.
 *
 * @package miniorange-2-factor-authentication/views/whitelabelling/
 */

use TwoFA\Helper\MoWpnsUtility;
use TwoFA\Helper\MoWpnsConstants;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$enable_2fa = MoWpnsUtility::get_mo2f_db_option( 'mo2f_activate_plugin', 'get_option' );
?>
<div class="mo2f-setup-two-factor-title mb-mo-4">
	<span><?php esc_html_e( 'Setup Custom Email Templates', 'miniorange-2-factor-authentication' ); ?></span>
</div>
<?php
$email_templates = array(
	MoWpnsConstants::mo2f_convert_method_name( MoWpnsConstants::OTP_OVER_EMAIL, 'cap_to_small' ) => array(
		'name'          => 'otp_over_email',
		'subject'       => 'mo2f_email_subject',
		'textarea_rows' => 18,
	),
	MoWpnsConstants::mo2f_convert_method_name( MoWpnsConstants::OUT_OF_BAND_EMAIL, 'cap_to_small' ) . ' Via Link' => array(
		'name'          => 'out_of_band_email',
		'subject'       => 'mo2f_email_ver_subject',
		'textarea_rows' => 20,
	),
	'Reset 2FA Via Reconfiguration Link on Email' => array(
		'name'          => 'reconfig_link_email',
		'subject'       => 'mo2f_2fa_reconfig_email_subject',
		'textarea_rows' => 19,
	),
	'Backup Codes'                                => array(
		'name'          => 'backup_code_email',
		'subject'       => 'mo2f_2fa_backup_code_email_subject',
		'textarea_rows' => 24,
	),
	'New IP Detected'                             => array(
		'name'          => 'new_ip_detected_email',
		'subject'       => 'mo2f_2fa_new_ip_detected_email_subject',
		'textarea_rows' => 18,
	),

);
foreach ( $email_templates  as $template_title => $content ) {
	?>
	<div class="mo2f-settings-div" id="<?php echo esc_attr( $content['subject'] ); ?>">
	<div class="mo2f-settings-head -ml-mo-9">	
	<span><?php esc_html_e( $template_title, 'miniorange-2-factor-authentication' );  //phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText -- The $text is a single string literal ?></span>	
</div>
<form name="mo2f_<?php echo esc_attr( $content['name'] ); ?>_template_form" method="post" action="" id="mo2f_<?php echo esc_attr( $content['name'] ); ?>_template">
			<div class="my-mo-3 ml-mo-16">
				<br>
				<b><?php esc_html_e( 'Email Subject:', 'miniorange-2-factor-authentication' ); ?></b>
				<input type="text" placeholder="Enter email subject" name="mo2f_email_subject" class="mo2f-email-subject" id="mo2f_subject" value="<?php echo esc_attr_e( MoWpnsUtility::get_mo2f_db_option( $content['subject'], 'site_option' ), 'miniorange-2-factor-authentication' ); //phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText -- The $text is a single string literal ?>">
			</div>



<br>
	<?php
	$data = MoWpnsUtility::get_mo2f_db_option( 'mo2f_' . $content['name'] . '_template', 'site_option' );
	?>

	<input type="hidden" name="option" value="mo2f_<?php echo esc_attr( $content['name'] ); ?>_template">
	<input type="hidden" name="subject_name" value="<?php echo esc_attr( $content['subject'] ); ?>">
	<input type="hidden" name="mo2f_whitelabelling_nonce" value="<?php echo esc_attr( wp_create_nonce( 'mo2f-whitelabelling-nonce' ) ); ?>">
	<div class="ml-mo-16">

	<?php
	wp_editor(
		$data,
		'mo2f_' . $content['name'] . '_template_config_message',
		array(
			'theme_advanced_buttons1' => 'bold, italic, ul, pH, pH_min',
			'media_buttons'           => true,
			'textarea_rows'           => $content['textarea_rows'],
			'tabindex'                => 4,
		)
	);
	?>
	<br>
<div class="justify-start <?php echo $enable_2fa ? 'flex' : 'hidden'; ?>" id="mo2f_enable2FA_save">
		<div><input type="submit" id="mo2f_<?php echo esc_attr( $content['name'] ); ?>_template_save_button" class="mo2f-save-settings-button" value="Save Email Configuration"></div>
		<div><input type="button" id="mo2f_<?php echo esc_attr( $content['name'] ); ?>_template_reset_button" class="mo2f-reset-settings-button ml-mo-4" value="Reset"></div>
</div>
</div>
</div>
	</form>
	<form name="f" id="mo2f_<?php echo esc_attr( $content['name'] ); ?>_reset_form" method="post" action="" hidden>
			<input type="hidden" name="option" value="mo2f_<?php echo esc_attr( $content['name'] ); ?>_reset">>
			<input type="hidden" name="subject_name" value="<?php echo esc_attr( $content['subject'] ); ?>">
			<input type="hidden" name="mo2f_whitelabelling_nonce" value="<?php echo esc_attr( wp_create_nonce( 'mo2f-whitelabelling-nonce' ) ); ?>"/>
	</form>

<br>
	<?php
}
?>
<script>
	jQuery('#emailtemplates').addClass('mo2f-subtab-active');
	jQuery("#mo_2fa_white_labelling").addClass("side-nav-active");
	jQuery( document ).ready(
	function($){
		jQuery( '#mo2f_backup_code_email_template_reset_button' ).click(function(){
			jQuery( '#mo2f_backup_code_email_reset_form').submit();
		});
		jQuery( '#mo2f_reconfig_link_email_template_reset_button' ).click(function(){
			jQuery( '#mo2f_reconfig_link_email_reset_form').submit();
		});
		jQuery( '#mo2f_out_of_band_email_template_reset_button' ).click(function(){
			jQuery( '#mo2f_out_of_band_email_reset_form').submit();
		});
		jQuery( '#mo2f_otp_over_email_template_reset_button' ).click(function(){
			jQuery( '#mo2f_otp_over_email_reset_form').submit();
		});
		jQuery( '#mo2f_new_ip_detected_email_template_reset_button' ).click(function(){
			jQuery( '#mo2f_new_ip_detected_email_reset_form').submit();
		});
	}
);
</script>


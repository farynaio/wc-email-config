<?php
/**
 * Plugin Name: WC Email Config
 * Plugin URI: https://github.com/adamfaryna/wc-email-config
 * Description: Wordpress Woocommerce WC_Email config plugin
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Author: Appdy LTD
 * Author URI: https://github.com/adamfaryna
 * Text Domain: appdy-email-config
 */

defined( 'ABSPATH' ) or die('No script kiddies please!');

class WC_Email_Config {

  function __construct() {
    add_action('phpmailer_init', [$this, 'configure_mailer']);
    add_action('phpmailer_init', [$this, 'fix_multipart_issue']);
    add_action('wp_mail_failed', [$this, 'handle_error']);

    load_plugin_textdomain('appdy-email-config', false, basename(dirname(__FILE__)) . '/languages');
  }

  function __destruct() {
    remove_action('phpmailer_init', [$this, 'configure_mailer']);
    remove_action('wp_mail_failed', [$this, 'handle_error']);
  }

  static function instance() {
    static $instance = null;

    if ($instance === null) {
      $instance = new WC_Email_Config();
    }

    return $instance;
  }

  function configure_mailer($mailer) {
    $config_path = apply_filters('appdy_wc_email_config_path', null);

    if ($config_path && file_exists($config_path)) {
      require_once($config_path);
      $mailer->isSMTP();
      $mailer->Host       = $config['smtp_host'];
      $mailer->SMTPAuth   = $config['smtp_auth'];
      $mailer->Port       = $config['smtp_port'];
      $mailer->SMTPSecure = $config['smtp_secure'];
      $mailer->Username   = $config['smtp_username'];
      $mailer->Password   = $config['smtp_password'];
      $mailer->From       = $config['smtp_from'];
      $mailer->FromName   = $config['smtp_fromname'];
      $mailer->SMTPDebug  = $config['debug_level'];
      $mailer->CharSet    = 'utf-8';

    } else {
      trigger_error(__('wc-email-config: no config file found!', 'wc-email-config'), E_USER_ERROR);
    }
  }

  function handle_error() {
    error_log('wp_mail failed: ' . $error->get_error_message());
  }

  function fix_multipart_issue($phpmailer) {
    if (empty($phpmailer->AltBody)) {
      $phpmailer->AltBody = strip_tags($phpmailer->Body);
    }
  }
}

WC_Email_Config::instance();

?>
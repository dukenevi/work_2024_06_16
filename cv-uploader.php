<?php
/**
 * Plugin Name: CV Upload Form
 * Plugin URI:
 * Version: 1.0.0
 * Author: Vadym
 * Author URI:
 * Description: Upload form
 */

namespace CSVUploader;


use CVUploader\Endpoint;
use CVUploader\Shortcode;

$composer = plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
require_once $composer;

/**
 *
 */
class CVUploader {
	public static string $plugin_name = 'cv-uploader';
	public static string $version = '1.0.0';

	public function __construct() {
		new Shortcode();
		new Endpoint();
	}

	public static function get_plugin_path() {
		return plugin_dir_path( __FILE__ );
	}

	public static function get_plugin_url() {
		return plugin_dir_url( __FILE__ );
	}

	/**
	 * @return void
	 */
	public function activation(): void {
		$install = get_option( self::$plugin_name . '_install' );
		$install = ! empty( $install ) ? (int) $install + 1 : 1;
		update_option( self::$plugin_name . '_install', $install );
	}

	/**
	 * @return void
	 */
	public function deactivation(): void {
		delete_option( self::$plugin_name . '_install' );
	}
}

new CVUploader();
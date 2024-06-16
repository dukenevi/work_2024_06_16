<?php

namespace CVUploader;

use CSVUploader\CVUploader;

class Shortcode {

	public function __construct() {
		add_action( 'init', [ $this, 'register_shortcodes' ] );
	}

	/**
	 * @return void
	 */
	public function register_shortcodes(): void {
		add_shortcode( 'cv_form', [ $this, 'cv_form_shortcode' ] );
	}

	/**
	 * @param array|null $atts
	 *
	 * @return string|null
	 */
	public function cv_form_shortcode( ?array $atts = null ): ?string {
		wp_enqueue_style(
			'bootstrap-5',
			CVUploader::get_plugin_url() . 'assets/bootstrap-5.0.2-dist/css/bootstrap.css',
			null,
			CVUploader::$version
		);
		wp_enqueue_script(
			'bootstrap-5',
			CVUploader::get_plugin_url() . 'assets/bootstrap-5.0.2-dist/js/bootstrap.js',
			null,
			CVUploader::$version
		);
		wp_enqueue_script(
			CVUploader::$plugin_name,
			CVUploader::get_plugin_url() . 'assets/main.js',
			[ 'jquery' ],
			CVUploader::$version
		);
		wp_localize_script(
			CVUploader::$plugin_name,
			'myajax',
			[
				'url' => '/wp-json/cv_uploader/v1/uploader',
			]
		);

		return Helper::get_template( 'form' );
	}
}
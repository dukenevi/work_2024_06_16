<?php

namespace CVUploader;

use CSVUploader\CVUploader;

class Helper {

	/**
	 * @param array $file
	 * @param array|null $params
	 *
	 * @return array|int|\WP_Error
	 */
	public static function save_file( array $file, ?array $params ) {
		$base_dir = \wp_get_upload_dir()['basedir'];
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
		}
		$upload_result = \wp_handle_upload(
			$file,
			[ 'test_form' => false ]
		);
		if ( ! empty( $upload_result['url'] ) ) {

			// Prepare an array of post data for the attachment.
			$attachment = [
				'guid'           => $upload_result['url'],
				'post_mime_type' => $file['type'],
				'post_title'     => $file['name'],
				'post_content'   => '',
				'post_status'    => 'inherit',
			];

			return \wp_insert_attachment( $attachment, $upload_result['file'] );
		}

		return $upload_result;
	}

	/**
	 * @param $name
	 * @param array $args
	 *
	 * @return string|null
	 */
	public static function get_template( $name, ?array $args = [] ): ?string {
		$template_path = CVUploader::get_plugin_path() . '/templates/' . $name . '.php';
		if ( file_exists( $template_path ) ) {
			extract( $args );
			ob_start();
			include $template_path;

			return ob_get_clean();
		}

		return null;
	}
}
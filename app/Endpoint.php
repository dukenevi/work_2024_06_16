<?php

namespace CVUploader;

use Exception;
use WP_REST_Request;
use WP_REST_Server;

class Endpoint {

	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_endpoints' ] );
	}

	/**
	 * @return void
	 */
	public function register_endpoints(): void {
		register_rest_route(
			'cv_uploader/v1',
			'/uploader',
			[
				[
					'methods'             => [ WP_REST_Server::CREATABLE ],
					'callback'            => [ $this, 'upload' ],
					'permission_callback' => '__return_true',
					'args'                => $this->params(),
				],
			]
		);
	}

	/**
	 * @return array[]
	 */
	public function params(): array {
		return [
			'firstname'  => [
				'description'       => 'Firstname',
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
				'required'          => true,
			],
			'secondname' => [
				'description'       => 'Secondname',
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
				'required'          => true,
			],
			'email'      => [
				'description'       => 'Email',
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
				'required'          => true,
			],
		];
	}

	/**
	 * @param WP_REST_Request $request
	 *
	 * @return void
	 */
	public function upload( WP_REST_Request $request ): void {
		try {
			$params = $request->get_params();

			if ( ! empty( $_FILES['cv-file'] ) && is_array( $_FILES['cv-file'] ) ) {
				$upload_result = Helper::save_file( $_FILES['cv-file'], $params );
				if ( is_numeric( $upload_result ) && 0 < $upload_result ) {
					$this->send_email(
						[
							'person'   => $params['firstname'] . ' ' . $params['secondname'],
							'email'    => $params['email'],
							'file_url' => wp_get_attachment_url( $upload_result ),
						]
					);
					wp_send_json_success( [
						'message' => Helper::get_template( 'thankyou' ),
						'$params' => $params,
					] );
				}
				wp_send_json_error(
					$upload_result
				);
			}

			wp_send_json_error(
				[
					'error' => 'Failed to upload file',
				]
			);

		} catch ( Exception $exception ) {
			wp_send_json_error(
				[
					'error' => $exception->getMessage(),
				]
			);
		}

	}

	/**
	 * @param array $params
	 *
	 * @return bool|mixed
	 */
	private function send_email( array $params ) {
		$email_context = Helper::get_template( 'email', $params );
		$subject       = 'A new CV has been uploaded';
		$admin_email   = get_option( 'admin_email' );

		return wp_mail( $admin_email, $subject, $email_context );
	}
}
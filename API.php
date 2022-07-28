<?php
require_once __DIR__ . '/Settings.php';

class Apex_API {
	public function add_routes() {
		register_rest_route( 'apex-api/v1', '/settings', array(
			'method'              => 'POST',
			'callback'            => array( $this, 'update_settings' ),
			'args'                => array(
				'industry' => array(
					'type'              => 'string',
					'required'          => false,
					'sanitize_callback' => 'sanitize_text_field',
				),
				'amount'   => array(
					'type'              => 'integer',
					'required'          => false,
					'sanitize_callback' => 'absint',
				),
			),
			'permission_callback' => array( $this, 'permissions' ),
		) );
		register_rest_route( 'apex-api/v1', '/settings', array(
			'method' => 'GET',
			'callback' => array( $this, 'get_settings'),
			'args' => array(

			),
			'permission_callback' => array( $this, 'permissions')
		) );
	}

	public function permissions() {
		return current_user_can('manage_options');
	}

	public function update_settings( WP_REST_Request $request ) {
		$settings = array(
			'industry' => $request->get_param('industry'),
			'amount' => $request->get_param('amount')
		);
		Apex_Settings::save_settings( $settings );
		return rest_ensure_response(Apex_Settings::get_settings())->set_status(201);
	}

	public function get_settings( WP_REST_Request $request ) {
		return rest_ensure_response(Apex_Settings::get_settings());
	}
}

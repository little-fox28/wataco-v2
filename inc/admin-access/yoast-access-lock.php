<?php

if ( ! function_exists( 'wataco_lock_yoast_for_admin' ) ) {
	/**
	 * Restrict Yoast settings capability to administrators only.
	 *
	 * @return string
	 */
	function wataco_lock_yoast_for_admin() {
		return 'activate_plugins';
	}
}

if ( ! function_exists( 'wataco_force_hide_yoast' ) ) {
	/**
	 * Remove Yoast admin menu entries for non-admin users.
	 *
	 * @return void
	 */
	function wataco_force_hide_yoast() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			remove_menu_page( 'wpseo_dashboard' );
			remove_menu_page( 'wpseo_workouts' );
		}
	}
}

if ( ! function_exists( 'wataco_remove_yoast_admin_bar' ) ) {
	/**
	 * Remove Yoast node from the admin toolbar for non-admin users.
	 *
	 * @return void
	 */
	function wataco_remove_yoast_admin_bar() {
		global $wp_admin_bar;

		if ( ! current_user_can( 'activate_plugins' ) ) {
			$wp_admin_bar->remove_menu( 'wpseo-menu' );
		}
	}
}

add_filter( 'wpseo_manage_options_capability', 'wataco_lock_yoast_for_admin' );
add_action( 'admin_menu', 'wataco_force_hide_yoast', 99999 );
add_action( 'wp_before_admin_bar_render', 'wataco_remove_yoast_admin_bar' );

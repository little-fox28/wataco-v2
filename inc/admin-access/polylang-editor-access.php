<?php

if ( ! function_exists( 'wataco_show_polylang_for_editor' ) ) {
	/**
	 * Make Polylang menus available to Editors without plugin-management capability.
	 *
	 * @return void
	 */
	function wataco_show_polylang_for_editor() {
		global $menu, $submenu;

		if ( ! current_user_can( 'edit_others_posts' ) || current_user_can( 'activate_plugins' ) ) {
			return;
		}

		// Update the parent menu capability.
		if ( isset( $menu ) ) {
			foreach ( $menu as $key => $item ) {
				if ( isset( $item[2] ) && 'mlang' === $item[2] ) {
					$menu[ $key ][1] = 'edit_others_posts';
					break;
				}
			}
		}

		// Update Polylang submenu capabilities.
		if ( isset( $submenu['mlang'] ) ) {
			foreach ( $submenu['mlang'] as $key => $item ) {
				$submenu['mlang'][ $key ][1] = 'edit_others_posts';
			}
		}
	}
}

if ( ! function_exists( 'wataco_polylang_virtual_cap' ) ) {
	/**
	 * Grant temporary manage_options when Editor is on Polylang screens or Polylang AJAX actions.
	 *
	 * @param array   $allcaps All capabilities for the user.
	 * @param array   $caps    Primitive capabilities being checked.
	 * @param array   $args    Context arguments.
	 * @param WP_User $user    Current user object.
	 * @return array
	 */
	function wataco_polylang_virtual_cap( $allcaps, $caps, $args, $user ) {
		unset( $caps, $args, $user );

		$is_editor_without_plugin_cap = ! empty( $allcaps['edit_others_posts'] ) && empty( $allcaps['activate_plugins'] );

		if ( ! $is_editor_without_plugin_cap ) {
			return $allcaps;
		}

		$page_param = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';
		$ajax_action = isset( $_POST['action'] ) ? sanitize_key( wp_unslash( $_POST['action'] ) ) : '';

		$is_mlang_page = is_admin() && 0 === strpos( $page_param, 'mlang' );
		$is_mlang_ajax = wp_doing_ajax() && false !== strpos( $ajax_action, 'pll_' );

		if ( $is_mlang_page || $is_mlang_ajax ) {
			$allcaps['manage_options'] = true;
		}

		return $allcaps;
	}
}

if ( ! function_exists( 'wataco_clean_ui_for_editor' ) ) {
	/**
	 * Hide Settings menu to keep Editor UI clean and avoid confusion.
	 *
	 * @return void
	 */
	function wataco_clean_ui_for_editor() {
		if ( current_user_can( 'edit_others_posts' ) && ! current_user_can( 'activate_plugins' ) ) {
			remove_menu_page( 'options-general.php' );
		}
	}
}

add_action( 'admin_menu', 'wataco_show_polylang_for_editor', 999 );
add_filter( 'user_has_cap', 'wataco_polylang_virtual_cap', 10, 4 );
add_action( 'admin_menu', 'wataco_clean_ui_for_editor', 9999 );

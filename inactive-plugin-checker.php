<?php
/**
 * Plugin Name: Multisite inactive plugins checker.
 * Description: Checks which plugins are inactive for a multisite.
 * Author: Souptik Datta
 * Version: 1.0
 * Author URI: https://souptik.dev

 * @package inactive-plugin-checker
 */

if ( ! function_exists( 'get_plugins' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}


/**
 * Get plugin's slug from plugin path.
 *
 * @param string $plugin Plugin path.
 *
 * @return string Plugin slug.
 */
function sd_get_plugin_slug( $plugin ) {
	$parts = explode( '/', $plugin );
	return $parts[0];
}

/**
 * Prints inactive plugins for multisite.
 *
 * ## OPTIONS
 *
 * [--extra-logs=<type>]
 * : Whether or not to show extra logs such as network activated plugins, all plugins, etc.
 * ---
 * default: false
 * options:
 *   - true
 *   - false
 * ---
 *
 * ## EXAMPLES
 *
 *     wp sd-inactive-plugin-checker --extra-logs=true
 *
 * @param array $args Args.
 * @param array $assoc_args Assoc args.
 *
 * @return void
 */
function sd_get_inactive_plugins( $args, $assoc_args ) {

	$assoc_args = wp_parse_args(
		$assoc_args,
		array(
			'extra-logs' => false,
		)
	);

	$extra_logs = ( 'true' === $assoc_args['extra-logs'] );

	$all_active_plugins = array();

	$sites = get_sites(
		array(
			'fields'   => 'ids',
			'archived' => 0,
		)
	);

	$all_plugins = array_keys( get_plugins() );
	$all_plugins = array_map( 'sd_get_plugin_slug', $all_plugins );

	if ( $extra_logs ) {
		WP_CLI::log( 'All plugins:', 'inactive-plugin-checker' );
		var_dump( $all_plugins );
	}

	foreach ( $sites as $site_id ) {

		switch_to_blog( $site_id );

		$active_for_this_site = get_option( 'active_plugins', array() );

		$all_active_plugins = array_merge( $all_active_plugins, $active_for_this_site );

	}

	$all_active_plugins = array_unique( $all_active_plugins );

	$all_active_plugins = array_map( 'sd_get_plugin_slug', $all_active_plugins );

	if ( $extra_logs ) {
		WP_CLI::log( __( 'All site active plugins:', 'inactive-plugin-checker' ) );
		var_dump( $all_active_plugins );
	}

	$network_activated_plugins = get_site_option( 'active_sitewide_plugins' );
	$network_activated_plugins = array_keys( $network_activated_plugins );
	$network_activated_plugins = array_map( 'sd_get_plugin_slug', $network_activated_plugins );

	if ( $extra_logs ) {
		WP_CLI::log( __( 'Network active plugins:', 'inactive-plugin-checker' ) );
		var_dump( $network_activated_plugins );
	}

	$all_active_plugins = array_merge( $all_active_plugins, $network_activated_plugins );
	$all_active_plugins = array_unique( $all_active_plugins );

	if ( $extra_logs ) {
		WP_CLI::log( __( 'All active plugins:', 'inactive-plugin-checker' ) );
		var_dump( $all_active_plugins );
	}

	$all_inactive_plugins = array_diff( $all_plugins, $all_active_plugins );

	WP_CLI::log( __( 'All inactive plugins:', 'inactive-plugin-checker' ) );
	var_dump( $all_inactive_plugins );

}

WP_CLI::add_command( 'sd-inactive-plugin-checker', 'sd_get_inactive_plugins' );

<?php
/**
 * \dimadin\WP\Plugin\ChangeCoreSlugs\Admin\PluginActionLink class.
 *
 * @package ChangeCoreSlugs
 * @since 1.0.0
 */

namespace dimadin\WP\Plugin\ChangeCoreSlugs\Admin;

/**
 * Class that adds actions link in plugins list.
 *
 * @since 1.0.0
 */
class PluginActionLink {
	/**
	 * Show action links on the plugin screen.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $actions     An array of plugin action links.
	 * @param string $plugin_file Path to the plugin file relative to the plugins directory.
	 * @param array  $plugin_data An array of plugin data. See `get_plugin_data()`.
	 * @return array $actions
	 */
	public static function add( $actions, $plugin_file, $plugin_data ) {
		if ( array_key_exists( 'TextDomain', $plugin_data ) && 'change-core-slugs' === $plugin_data['TextDomain'] ) {
			$actions['settings'] = '<a href="' . add_query_arg( 'page', 'change-core-slugs', admin_url( 'options-general.php' ) ) . '">' . esc_html__( 'Settings', 'change-core-slugs' ) . '</a>';
		}

		return $actions;
	}
}

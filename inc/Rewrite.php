<?php
/**
 * \dimadin\WP\Plugin\ChangeCoreSlugs\Rewrite class.
 *
 * @package ChangeCoreSlugs
 * @since 1.0.0
 */

namespace dimadin\WP\Plugin\ChangeCoreSlugs;

use dimadin\WP\Plugin\ChangeCoreSlugs\Settings;

/**
 * Class that sets custom slugs.
 *
 * @since 1.0.0
 */
class Rewrite {
	/**
	 * Set custom rewrite bases.
	 *
	 * @since 1.0.0
	 */
	public static function change() {
		$wp_rewrite = $GLOBALS['wp_rewrite'];

		foreach ( Settings::get_all() as $base => $base_settings ) {
			$value = get_option( 'ccs_' . $base );
			if ( $value && ( is_string( $value ) || is_int( $value ) ) ) {
				$wp_rewrite->$base = $value;

				// For feed base, set feed type of the same slug.
				if ( 'feed_base' === $base ) {
					$wp_rewrite->feeds[] = $value;
				}
			}
		}
	}

	/**
	 * Delete option with cached rewrite rules.
	 *
	 * @since 1.0.0
	 */
	public static function delete_rules() {
		update_option( 'rewrite_rules', '' );
	}

	/**
	 * Set 'feed' feed type after parsing query of custom WP_Rewrite::feed_base.
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_Query $query The WP_Query instance.
	 */
	public static function set_feed( $query ) {
		$wp_rewrite = $GLOBALS['wp_rewrite'];

		$feed = $query->get( 'feed' );

		if ( $feed && ( get_option( 'ccs_feed_base' ) === $feed ) && ( $feed === $wp_rewrite->feed_base ) ) {
			$query->set( 'feed', 'feed' );
		}
	}

	/**
	 * Maybe schedule to delete option with cached rewrite rules on shutdown.
	 *
	 * @since 1.0.0
	 */
	public static function register_delete_rules_on_shutdown() {
		if ( ! has_action( 'shutdown', [ __NAMESPACE__ . '\Rewrite', 'delete_rules' ] ) ) {
			add_action( 'shutdown', [ __NAMESPACE__ . '\Rewrite', 'delete_rules' ] );
		}
	}
}

<?php
/**
 * \dimadin\WP\Plugin\ChangeCoreSlugs\Settings class.
 *
 * @package ChangeCoreSlugs
 * @since 1.0.0
 */

namespace dimadin\WP\Plugin\ChangeCoreSlugs;

use dimadin\WP\Plugin\ChangeCoreSlugs\Rewrite;

/**
 * Class that register plugin settings.
 *
 * @since 1.0.0
 */
class Settings {
	/**
	 * Register settings fields.
	 *
	 * @since 1.0.0
	 */
	public static function register() {
		$args = [
			'sanitize_callback' => [ __NAMESPACE__ . '\Settings', 'sanitize' ],
		];

		// Register settings.
		foreach ( static::get_all() as $base => $base_settings ) {
			register_setting( 'ccs_settings_section', 'ccs_' . $base, $args );
		}
	}

	/**
	 * Sanitize passed parameter and register cached rewrite rules delete.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $value Value to sanitize.
	 * @return string
	 */
	public static function sanitize( $value ) {
		// Add hook to delete rewrite rules.
		Rewrite::register_delete_rules_on_shutdown();

		// Do real sanitization of input.
		return sanitize_text_field( $value );
	}

	/**
	 * Get an array with settings of all bases.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_all() {
		// phpcs:disable WordPress.Arrays.MultipleStatementAlignment.DoubleArrowNotAligned
		$bases = [
			'author_base' => [
				'name'        => __( 'Author Base', 'change-core-slugs' ),
				'description' => __( 'Base in the author permalink. By default <strong>author</strong> (example <code>example.com/author/username/</code>).', 'change-core-slugs' ),
			],
			'search_base' => [
				'name'        => __( 'Search Base', 'change-core-slugs' ),
				'description' => __( 'Base in the search permalink. By default <strong>search</strong> (example <code>example.com/search/keyword/</code>).', 'change-core-slugs' ),
			],
			'comments_base' => [
				'name'        => __( 'Comments Base', 'change-core-slugs' ),
				'description' => __( 'Base in the comments feed permalink. By default <strong>comments</strong> (example <code>example.com/comments/feed/</code>).', 'change-core-slugs' ),
			],
			'pagination_base' => [
				'name'        => __( 'Pagination Base', 'change-core-slugs' ),
				'description' => __( 'Base in the pagination permalink. By default <strong>page</strong> (example <code>example.com/page/5/</code>).', 'change-core-slugs' ),
			],
			'comments_pagination_base' => [
				'name'        => __( 'Comments Pagination Base', 'change-core-slugs' ),
				'description' => __( 'Base in the post comments pagination permalink. By default <strong>comment-page</strong> (example <code>example.com/hello-world/comment-page-3/</code>).', 'change-core-slugs' ),
			],
			'feed_base' => [
				'name'        => __( 'Feed Base', 'change-core-slugs' ),
				'description' => __( 'Base in the feed pagination permalink. By default <strong>feed</strong> (example <code>example.com/feed/</code>).', 'change-core-slugs' ),
			],
		];

		// phpcs:enable

		return $bases;
	}
}

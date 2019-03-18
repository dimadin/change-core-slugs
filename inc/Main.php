<?php
/**
 * \dimadin\WP\Plugin\ChangeCoreSlugs\Main class.
 *
 * @package ChangeCoreSlugs
 * @since 1.0.0
 */

namespace dimadin\WP\Plugin\ChangeCoreSlugs;

use dimadin\WP\Plugin\ChangeCoreSlugs\SingletonTrait;

/**
 * Class with methods that initialize Change Core Slugs.
 *
 * This class hooks other parts of Change Core Slugs, and
 * other methods that are important for functioning
 * of Change Core Slugs.
 *
 * @since 1.0.0
 */
class Main {
	use SingletonTrait;

	/**
	 * Constructor.
	 *
	 * This method is used to hook everything.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		static::hook();
	}

	/**
	 * Hook everything.
	 *
	 * @since 1.0.0
	 */
	public static function hook() {
		// phpcs:disable PEAR.Functions.FunctionCallSignature.SpaceBeforeCloseBracket, Generic.Functions.FunctionCallArgumentSpacing.TooMuchSpaceAfterComma, WordPress.Arrays.CommaAfterArrayItem.SpaceAfterComma, WordPress.Arrays.ArrayDeclarationSpacing.SpaceBeforeArrayCloser, Generic.Functions.FunctionCallArgumentSpacing.SpaceBeforeComma

		// Register settings fields.
		add_action( 'init',                                               [ __NAMESPACE__ . '\Settings',                    'register'         ], 2           );

		// Display settings fields.
		add_action( 'admin_menu',                                         [ __NAMESPACE__ . '\Admin\Page\Settings',         'get_instance'     ], 2           );

		// Change core, default permalink bases.
		add_action( 'after_setup_theme',                                  [ __NAMESPACE__ . '\Rewrite',                     'change'           ], PHP_INT_MAX );

		add_action( 'deactivate_change-core-slugs/change-core-slugs.php', [ __NAMESPACE__ . '\Rewrite',                     'delete_rules'     ], 2           );

		add_action( 'parse_query',                                        [ __NAMESPACE__ . '\Rewrite',                     'set_feed'         ], 2           );

		// Show action links on the plugin screen.
		add_filter( 'plugin_action_links',                                [ __NAMESPACE__ . '\Admin\PluginActionLink',      'add'              ], 10, 3       );

		// phpcs:enable
	}
}

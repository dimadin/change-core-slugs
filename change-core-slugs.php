<?php
/**
 * Plugin Name: Change Core Slugs
 * Plugin URI:  https://milandinic.com/wordpress/plugins/change-core-slugs/
 * Description: Set custom permalink slugs instead of default ones.
 * Author:      Milan Dinić
 * Author URI:  https://milandinic.com/
 * Version:     1.0.0
 * Text Domain: change-core-slugs
 * Domain Path: /languages/
 *
 * @package ChangeCoreSlugs
 */

// Load dependencies.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

/*
 * Initialize a plugin.
 *
 * Load class when all plugins are loaded
 * so that other plugins can overwrite it.
 */
add_action( 'plugins_loaded', [ 'dimadin\WP\Plugin\ChangeCoreSlugs\Main', 'get_instance' ], 15 );

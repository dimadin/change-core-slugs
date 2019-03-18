<?php
/**
 * Uninstall procedure for Change Core Slugs.
 *
 * @package ChangeCoreSlugs
 * @subpackage Uninstall
 * @since 1.0.0
 */

// Exit if accessed directly or not on uninstall.
if ( ! defined( 'ABSPATH' ) || ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete settings.
$ccs_bases = [
	'author_base',
	'search_base',
	'comments_base',
	'pagination_base',
	'comments_pagination_base',
	'feed_base',
];

foreach ( $ccs_bases as $ccs_base ) {
	delete_option( 'ccs_' . $ccs_base );
}

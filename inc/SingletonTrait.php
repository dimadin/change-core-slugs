<?php
/**
 * \dimadin\WP\Plugin\ChangeCoreSlugs\SingletonTrait class.
 *
 * @package ChangeCoreSlugs
 * @since 1.0.0
 */

namespace dimadin\WP\Plugin\ChangeCoreSlugs;

/**
 * Singleton pattern.
 *
 * @since 1.0.0
 *
 * @link http://www.sitepoint.com/using-traits-in-php-5-4/
 */
trait SingletonTrait {
	/**
	 * Instantiate called class.
	 *
	 * @since 1.0.0
	 *
	 * @staticvar bool|object $instance
	 *
	 * @return object $instance Instance of called class.
	 */
	public static function get_instance() {
		static $instance = false;

		if ( false === $instance ) {
			$instance = new static();
		}

		return $instance;
	}
}

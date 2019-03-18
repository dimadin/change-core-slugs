<?php
/**
 * \dimadin\WP\Plugin\ChangeCoreSlugs\Admin\Page\Settings class.
 *
 * @package ChangeCoreSlugs
 * @since 1.0.0
 */

namespace dimadin\WP\Plugin\ChangeCoreSlugs\Admin\Page;

use dimadin\WP\Plugin\ChangeCoreSlugs\SingletonTrait;
use dimadin\WP\Plugin\ChangeCoreSlugs\Settings as ConfigSettings;

/**
 * Class for displaying admin settings.
 *
 * @since 1.0.0
 */
class Settings {
	use SingletonTrait;

	/**
	 * An array with settings of all bases.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $bases = [];
	/**
	 * An array with settings for core tag and category bases.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $tax_bases = [];

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->bases = ConfigSettings::get_all();

		$this->tax_bases = [
			'category_base' => [
				'name'        => __( 'Category Base', 'change-core-slugs' ),
				'description' => __( 'Base in the category permalink. By default <strong>category</strong> (example <code>example.com/category/uncategorized/</code>).', 'change-core-slugs' ),
			],
			'tag_base'      => [
				'name'        => __( 'Tag Base', 'change-core-slugs' ),
				'description' => __( 'Base in the tag permalink. By default <strong>tag</strong> (example <code>example.com/tag/term/</code>).', 'change-core-slugs' ),
			],
		];

		// Register settings page.
		add_action( 'admin_menu', [ $this, 'register_settings_page' ] );

		// Register settings.
		add_action( 'admin_init', [ $this, 'register_settings_fields' ] );
	}

	/**
	 * Magic method handler.
	 *
	 * This method is used to handle settings fields display.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method Method name.
	 * @param array  $args   Arguments to the method.
	 */
	public function __call( $method, $args ) {
		if ( 0 === strpos( $method, 'render_field_' ) ) {
			$base = str_replace( 'render_field_', '', $method );

			if ( ! array_key_exists( $base, $this->bases ) ) {
				return;
			}

			$this->render_field( $base );
		} elseif ( 0 === strpos( $method, 'render_tax_field_' ) ) {
			$base = str_replace( 'render_tax_field_', '', $method );

			if ( ! array_key_exists( $base, $this->tax_bases ) ) {
				return;
			}

			$this->render_tax_field( $base );
		}
	}

	/**
	 * Register settings page.
	 *
	 * @since 1.0.0
	 */
	public function register_settings_page() {
		add_submenu_page(
			'options-general.php',
			__( 'Change Core Slugs Settings', 'change-core-slugs' ),
			__( 'Change Core Slugs', 'change-core-slugs' ),
			'manage_options',
			'change-core-slugs',
			[ $this, 'display_settings_page' ]
		);
	}

	/**
	 * Display settings page.
	 *
	 * @since 1.0.0
	 */
	public function display_settings_page() {
		?>
		<div class="wrap">
			<form method="post" action="options.php">
				<?php
				settings_fields( 'ccs_settings_section' );

				do_settings_sections( 'change-core-slugs' );

				// Add the submit button to serialize the options.
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register settings fields.
	 *
	 * @since 1.0.0
	 */
	public function register_settings_fields() {
		// Register settings section.
		add_settings_section(
			'ccs_settings_section',
			__( 'Change Core Slugs Settings', 'change-core-slugs' ),
			[ $this, 'display_settings_section' ],
			'change-core-slugs'
		);

		// Register settings fields display.
		foreach ( $this->bases as $base => $base_settings ) {
			add_settings_field(
				'ccs_' . $base,
				$base_settings['name'],
				[ $this, 'render_field_' . $base ],
				'change-core-slugs',
				'ccs_settings_section'
			);
		}

		// Register category and tag bases fields display.
		foreach ( $this->tax_bases as $base => $base_settings ) {
			add_settings_field(
				'ccs_' . $base,
				$base_settings['name'],
				[ $this, 'render_tax_field_' . $base ],
				'change-core-slugs',
				'ccs_settings_section'
			);
		}
	}

	/**
	 * Display settings section.
	 *
	 * This is an empty method.
	 *
	 * @since 1.0.0
	 */
	public function display_settings_section() {}

	/**
	 * Display setting field.
	 *
	 * @since 1.0.0
	 *
	 * @param string $base Name of the base.
	 */
	protected function render_field( $base ) {
		if ( ! array_key_exists( $base, $this->bases ) ) {
			return;
		}

		$base_settings = $this->bases[ $base ];
		$key           = 'ccs_' . $base;
		$value         = get_option( $key );
		?>
		<input type="text" id="<?php echo esc_attr( $key ); ?>" class="regular-text ltr" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>" />
		<br />
		<?php
		if ( ! array_key_exists( 'description', $base_settings ) ) {
			return;
		}

		$allowed_html = [
			'br'     => [],
			'code'   => [],
			'em'     => [],
			'pre'    => [],
			'strong' => [],
		];
		?>
		<span class="description"><?php echo wp_kses( $base_settings['description'], $allowed_html ); ?></span>
		<?php
	}

	/**
	 * Display category or tag base field.
	 *
	 * @since 1.0.0
	 *
	 * @param string $base Name of the base.
	 */
	public function render_tax_field( $base ) {
		if ( ! array_key_exists( $base, $this->tax_bases ) ) {
			return;
		}

		$allowed_html = [
			'br'     => [],
			'code'   => [],
			'em'     => [],
			'pre'    => [],
			'strong' => [],
		];

		$base_settings = $this->tax_bases[ $base ];
		printf(
			wp_kses(
				/* translators: link to the Settings > Permalinks page */
				__( 'This base can be changed at <a href="%s">Settings > Permalinks</a> page.', 'change-core-slugs' ),
				array_merge( $allowed_html, [ 'a' => [ 'href' => [] ] ] )
			),
			esc_url( admin_url( 'options-permalink.php' ) )
		);
		?>

		<br />
		<span class="description"><?php echo wp_kses( $base_settings['description'], $allowed_html ); ?></span>
		<?php
	}
}

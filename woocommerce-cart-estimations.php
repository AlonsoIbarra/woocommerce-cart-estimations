<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/AlonsoIbarra
 * @since             1.0.0
 * @package           Woocommerce_Cart_Estimations
 *
 * @wordpress-plugin
 * Plugin Name:       Woocommerce cart estimations
 * Plugin URI:        https://github.com/AlonsoIbarra/woocommerce-cart-estimations
 * Description:       This Wordpress plugin overwrites cart button behavior in order to redirect to a pdf web page that shows an budget based in current cart content.
 * Version:           1.0.0
 * Author:            Saul Alonso Ibarra Luevano
 * Author URI:        https://github.com/AlonsoIbarra
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-cart-estimations
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOOCOMMERCE_CART_ESTIMATIONS_VERSION', '1.0.0' );

/**
 * Plugin name for futire references.
 */
define( 'PLUGIN_NAME', 'Woocommerce cart estimations' );

/**
 * Plugin slug for futire references.
 */
define( 'PLUGIN_SLUG', 'woocommerce-cart-estimations' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-cart-estimations-activator.php
 */
function activate_woocommerce_cart_estimations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-cart-estimations-activator.php';
	Woocommerce_Cart_Estimations_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-cart-estimations-deactivator.php
 */
function deactivate_woocommerce_cart_estimations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-cart-estimations-deactivator.php';
	Woocommerce_Cart_Estimations_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woocommerce_cart_estimations' );
register_deactivation_hook( __FILE__, 'deactivate_woocommerce_cart_estimations' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-cart-estimations.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_cart_estimations() {

	$plugin = new Woocommerce_Cart_Estimations();
	$plugin->run();

}

run_woocommerce_cart_estimations();

if ( !function_exists( 'woocommerce_cart_estimations_settings_init' ) ) {
	/**
	 * custom option and settings
	 */
	function woocommerce_cart_estimations_settings_init() {
		/**
		 *  Register a new setting for "woocommerce_cart_estimations" page.
		 * Note: should be the same for option_group and option_name in order to avoid 'option not allowed error'.
		 **/
		register_setting(
			'woocommerce_cart_estimations_options',
			'woocommerce_cart_estimations_options'
		);

		// Register a new section in the "woocommerce_cart_estimations" page.
		add_settings_section(
			'woocommerce_cart_estimations_section_developers',
			__( 'Configuración', PLUGIN_SLUG ),
			'woocommerce_cart_estimations_section_developers_instructions',
			'woocommerce_cart_estimations'
		);
	}
	add_action( 'admin_init', 'woocommerce_cart_estimations_settings_init' );
}

if ( !function_exists( 'woocommerce_cart_estimations_section_developers_instructions' ) ) {
	/**
	 * Section introduction to give section overview.
	 *
	 * @param array $args  The settings array, defining title, id, callback.
	 */
	function woocommerce_cart_estimations_section_developers_instructions( $args ) {
		?>
		<p>
			<?php esc_html_e( 'Sección para personalizar la vista y el comportamiento del botón de carrito de Woocommerce.', PLUGIN_SLUG ); ?>
		</p>
		<?php
	}
}

if ( !function_exists( 'woocommerce_cart_estimations_options_page' ) ) {
	/**
	 * Add the top level menu page.
	 */
	function woocommerce_cart_estimations_options_page() {
		add_menu_page(
			PLUGIN_NAME,
			PLUGIN_NAME,
			'manage_options',
			PLUGIN_SLUG,
			'woocommerce_cart_estimations_options_page_html',
			'dashicons-calculator'
		);
	}
	/**
	 * Register our woocommerce_cart_estimations_options_page to the admin_menu action hook.
	 */
	add_action( 'admin_menu', 'woocommerce_cart_estimations_options_page', 0 );
}



if ( !function_exists( 'woocommerce_cart_estimations_options_page_html' ) ) {
	/**
	 * Function to render plugin settings form.
	 */
	function woocommerce_cart_estimations_options_page_html() {
		// check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// show error/update messages
		settings_errors( 'wporg_messages' );
		?>
		<div class="wrap">
			<h1><strong><?php echo esc_html( get_admin_page_title() ); ?></strong></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'woocommerce_cart_estimations_options' );
				do_settings_sections( 'woocommerce_cart_estimations' );
				submit_button(
					__( 'Guardar', PLUGIN_SLUG )
				);
				?>
			</form>
		</div>
		<?php
	}
}

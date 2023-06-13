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

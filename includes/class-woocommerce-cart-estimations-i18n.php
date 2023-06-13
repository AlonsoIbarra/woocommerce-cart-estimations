<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/AlonsoIbarra
 * @since      1.0.0
 *
 * @package    Woocommerce_Cart_Estimations
 * @subpackage Woocommerce_Cart_Estimations/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Cart_Estimations
 * @subpackage Woocommerce_Cart_Estimations/includes
 * @author     Saul Alonso Ibarra Luevano <isaul37@hotmail.es>
 */
class Woocommerce_Cart_Estimations_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woocommerce-cart-estimations',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

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
 * Flag to disable custom behabor for woocommerce cart.
 */
$plugin_options = get_option( 'woocommerce_cart_estimations_options' );
define( 'DISABLE_PLUGIN_BEHAVOR', boolval( isset( $plugin_options['disable_plugin_behavor'] ) ? $plugin_options['disable_plugin_behavor'] : false ) );

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

		// Register a new field in the "woocommerce_cart_estimations_section_developers" section.
		add_settings_field(
			'woocommerce_cart_estimations_disable_plugin_behavor',
			__( 'Desabilitar configuraciones de ' . PLUGIN_NAME, PLUGIN_SLUG ),
			'woocommerce_cart_estimations_disable_plugin_behavor_callback',
			'woocommerce_cart_estimations',
			'woocommerce_cart_estimations_section_developers'
		);

		// Register a new field in the "woocommerce_cart_estimations_section_developers" section.
		add_settings_field(
			'woocommerce_cart_estimations_add_to_cart_label',
			__( 'Texto de botón "agregar a carrito"', PLUGIN_SLUG ),
			'woocommerce_cart_estimations_add_to_cart_label_callback',
			'woocommerce_cart_estimations',
			'woocommerce_cart_estimations_section_developers'
		);

		// Register a new field in the "woocommerce_cart_estimations_section_developers" section.
		add_settings_field(
			'woocommerce_cart_estimations_checkout_button_text',
			__( 'Texto de botón "finalizar compra"', PLUGIN_SLUG ),
			'woocommerce_cart_estimations_checkout_button_text_callback',
			'woocommerce_cart_estimations',
			'woocommerce_cart_estimations_section_developers'
		);

		// Register a new field in the "woocommerce_cart_estimations_section_developers" section.
		add_settings_field(
			'woocommerce_cart_estimations_empty_cart_after_chekout',
			__( 'Vaciar carrito al continuar', PLUGIN_SLUG ),
			'woocommerce_cart_estimations_empty_cart_after_chekout_callback',
			'woocommerce_cart_estimations',
			'woocommerce_cart_estimations_section_developers'
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

if ( !function_exists( 'woocommerce_cart_estimations_disable_plugin_behavor_callback' ) ) {
	/**
	 * Render controls to let the user disable plugin customizartions for woocommerce cart.
	 */
	function woocommerce_cart_estimations_disable_plugin_behavor_callback() {
		$options = get_option( 'woocommerce_cart_estimations_options' );
		$checked = ( isset( $options['disable_plugin_behavor'] ) ) ? checked( true, boolval( $options['disable_plugin_behavor'] ), false ) : '';
		?>
		<input type="checkbox" name="woocommerce_cart_estimations_options[disable_plugin_behavor]" id="woocommerce_cart_estimations_options[disable_plugin_behavor]" <?php echo esc_html( $checked ); ?>>
		<p class="description" style="color:red;">
			<?php echo __( 'Esta opcion permite deshabilitar el comportamiento personalizado para woocommerce sin tener que deshabilitar el plugin.', PLUGIN_SLUG ); ?>
		</p>
		<?php
	}
}

if ( !function_exists( 'woocommerce_cart_estimations_add_to_cart_label_callback' ) ) {
	/**
	 * Render controls to update 'Add to cart' button text field callback.
	 */
	function woocommerce_cart_estimations_add_to_cart_label_callback() {
		// Get the value of the setting we've registered with register_setting()
		$options = get_option( 'woocommerce_cart_estimations_options' );
		?>
		<input type="text" name="woocommerce_cart_estimations_options[add_to_cart_text]" id="woocommerce_cart_estimations_options[add_to_cart_text]" value="<?php echo $options['add_to_cart_text']; ?>">

		<p class="description">
			<?php echo __( 'Este texto aparecera en el botón para agregar un producto simple a carrito.', PLUGIN_SLUG ); ?>
		</p>
		<?php
	}
}

if ( !function_exists( 'woocommerce_cart_estimations_checkout_button_text_callback' ) ) {
	/**
	 * Render controls to update 'Checkout' cart button text field.
	 */
	function woocommerce_cart_estimations_checkout_button_text_callback() {
		// Get the value of the setting we've registered with register_setting()
		$options = get_option( 'woocommerce_cart_estimations_options' );
		?>
		<input type="text" name="woocommerce_cart_estimations_options[checkout_button_text]" id="woocommerce_cart_estimations_options[checkout_button_text]" value="<?php echo $options['checkout_button_text']; ?>">

		<p class="description">
			<?php echo __( 'Este texto aparecerá en el botón para finalizar compra en la página de carrito.', PLUGIN_SLUG ); ?>
		</p>
		<?php
	}
}

if ( !function_exists( 'woocommerce_cart_estimations_empty_cart_after_chekout_callback' ) ) {
	/**
	 * Render controls to update 'empty_cart_after_chekout' settings option.
	 */
	function woocommerce_cart_estimations_empty_cart_after_chekout_callback() {
		$options = get_option( 'woocommerce_cart_estimations_options' );
		$checked = ( isset( $options['empty_cart_after_chekout'] ) ) ? checked( true, boolval( $options['empty_cart_after_chekout'] ), false ) : '';
		?>
		<input type="checkbox" name="woocommerce_cart_estimations_options[empty_cart_after_chekout]" id="woocommerce_cart_estimations_options[empty_cart_after_chekout]" <?php echo esc_html( $checked ); ?>>
		<p class="description">
			<?php echo __( 'Vaciar carrito despues de seleccionar botón de continuar.', PLUGIN_SLUG ); ?>
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

if ( !function_exists( 'wo_cart_estimations_custom_add_to_cart_text' ) && ! DISABLE_PLUGIN_BEHAVOR ) {
	/**
	 * This function over writes woocommerce_product_single_add_to_cart_text for custom 'add to cart' button text.
	 */
	function wo_cart_estimations_custom_add_to_cart_text() {
		$options = get_option( 'woocommerce_cart_estimations_options' );
		return __( $options['add_to_cart_text'], 'woocommerce-cart-estimations' ); 
	}
	add_filter( 'woocommerce_product_add_to_cart_text', 'wo_cart_estimations_custom_add_to_cart_text' ); 
	add_filter( 'woocommerce_product_single_add_to_cart_text', 'wo_cart_estimations_custom_add_to_cart_text' );
}

if ( ! function_exists( 'woocommerce_cart_remove_woocommerce_proceed_to_checkout' ) && ! DISABLE_PLUGIN_BEHAVOR ) {
	/**
	 * Function to delete checkout button from cart page.
	 */
	function woocommerce_cart_remove_woocommerce_proceed_to_checkout() {
		remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
	}
	add_action('init', 'woocommerce_cart_remove_woocommerce_proceed_to_checkout');
}

if ( !function_exists( 'woocommerce_cart_estimation_change_checkout_button' ) && ! DISABLE_PLUGIN_BEHAVOR ) {
	/**
	 * This function add html code for checkout cart section using woocommerce_proceed_to_checkout hook.
	 */
	function woocommerce_cart_estimation_change_checkout_button(){
		$options = get_option( 'woocommerce_cart_estimations_options' );
        ?>
        <a href="#" id="woocommerce_cart_estimations_checkout_button" class="checkout-button button alt wc-forward">
			<?php _e( $options['checkout_button_text'], PLUGIN_SLUG ); ?>
		</a>
        <?php   
	}
	add_action( 'woocommerce_proceed_to_checkout', 'woocommerce_cart_estimation_change_checkout_button' );
}


if ( ! function_exists( 'woocommerce_cart_estimations_pdf_request' ) ) {
	/**
	 * Function to proccess data and create pdf.
	 *
	 * @since    1.0.0
	 */
	function woocommerce_cart_estimations_pdf_request() {

		if ( ! isset( $_POST['key'] ) || '' === $_POST['key'] ) {
			wp_send_json_error(
				__( 'Acceso no permitido.', PLUGIN_SLUG )
			);
		}

		$key = sanitize_text_field( wp_unslash( $_POST['key'] ) );
		if ( ! wp_verify_nonce( $key, 'key' ) ) {
			wp_send_json_error(
				__( 'Petición incorrecta, actualice la página e intente nuevamente.', PLUGIN_SLUG )
			);
		}

		if ( ! wp_doing_ajax() ) {
			wp_send_json_error(
				__( 'Esta operación sólo puede ser usada mediante AJAX.', PLUGIN_SLUG )
			);
		}

		if ( is_null( WC()->cart ) ) {
			wp_send_json_error(
				sprintf(
					'%s',
					__( 'Petición incorrecta, actualice la página e intente nuevamente.', PLUGIN_SLUG )
				)
			);
		}
		if ( WC()->cart->is_empty() ) {
			wp_send_json_error(
				sprintf(
					'%s',
					__( 'Tu carrito se encuentra vacio.', PLUGIN_SLUG )
				)
			);
		}

		$response = woocommerce_cart_estimations_create_pdf();
		if ( $response ) :
			if ( str_contains( $response, 'http' ) ) :
				$options = get_option( 'woocommerce_cart_estimations_options' );
				if ( boolval( $options['empty_cart_after_chekout'] ) ){
					// Remove all cart items.
					WC()->cart->empty_cart();
				}
				wp_send_json_success( $response );
			endif;
			wp_send_json_error(
				$response
			);
		endif;
		wp_send_json_error(
			__( 'Ocurrio un error al general el archivo PDF, contacta al administrador.', PLUGIN_SLUG )
		);
	}
}
add_action( 'wp_ajax_woocommerce_cart_estimations_pdf_request', 'woocommerce_cart_estimations_pdf_request' );

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

/**
 * Add validation for Woocommerce dependency.
 */
 if ( ! in_array('woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	echo sprintf(
		__(
			'<div class="error"><p><strong>%s</strong> %s <a href="%s">%s</a>.</p></div>',
			PLUGIN_SLUG
		),
		PLUGIN_NAME,
		__(
			'requiere que WooCommerce esté activo. Por favor,',
			PLUGIN_SLUG
		),
		'plugins.php?action=activate&plugin=woocommerce%2Fwoocommerce.php&plugin_status=all&paged=1&s&_wpnonce=00182d052a',
		__(
			'activa WooCommerce',
			PLUGIN_SLUG
		)
	);
}

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

		// Register a new field in the "woocommerce_cart_estimations_section_developers" section.
		add_settings_field(
			'woocommerce_cart_estimations_create_order_after_chekout',
			__( 'Crear orden al continuar', PLUGIN_SLUG ),
			'woocommerce_cart_estimations_create_order_after_chekout_callback',
			'woocommerce_cart_estimations',
			'woocommerce_cart_estimations_section_developers'
		);

		// Register a new field in the "woocommerce_cart_estimations_section_developers" section.
		add_settings_field(
			'woocommerce_cart_estimations_set_customer_name_mandatory',
			__( 'Marcar como obligatorio el nombre completo del cliente', PLUGIN_SLUG ),
			'woocommerce_cart_estimations_set_customer_name_mandatory_callback',
			'woocommerce_cart_estimations',
			'woocommerce_cart_estimations_section_developers'
		);

		// Register a new field in the "woocommerce_cart_estimations_section_developers" section.
		add_settings_field(
			'woocommerce_cart_estimations_set_customer_email_mandatory',
			__( 'Marcar como obligatorio el correo electrónico del cliente', PLUGIN_SLUG ),
			'woocommerce_cart_estimations_set_customer_email_mandatory_callback',
			'woocommerce_cart_estimations',
			'woocommerce_cart_estimations_section_developers'
		);

		// Register a new field in the "woocommerce_cart_estimations_section_developers" section.
		add_settings_field(
			'woocommerce_cart_estimations_set_customer_phone_mandatory',
			__( 'Marcar como obligatorio el número telefónico del cliente', PLUGIN_SLUG ),
			'woocommerce_cart_estimations_set_customer_phone_mandatory_callback',
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
			<?php echo __( 'Esta opción permite deshabilitar el comportamiento personalizado para woocommerce sin tener que deshabilitar el plugin.', PLUGIN_SLUG ); ?>
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
			<?php echo __( 'Este texto aparecerá en el botón para agregar un producto simple a carrito.', PLUGIN_SLUG ); ?>
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
			<?php echo __( 'Vaciar carrito al seleccionar botón de continuar.', PLUGIN_SLUG ); ?>
		</p>
		<?php
	}
}

if ( !function_exists( 'woocommerce_cart_estimations_create_order_after_chekout_callback' ) ) {
	/**
	 * Render controls to update 'create_order_after_chekout' settings option.
	 */
	function woocommerce_cart_estimations_create_order_after_chekout_callback() {
		$options = get_option( 'woocommerce_cart_estimations_options' );
		$checked = ( isset( $options['create_order_after_chekout'] ) ) ? checked( true, boolval( $options['create_order_after_chekout'] ), false ) : '';
		?>
		<input type="checkbox" name="woocommerce_cart_estimations_options[create_order_after_chekout]" id="woocommerce_cart_estimations_options[create_order_after_chekout]" <?php echo esc_html( $checked ); ?>>
		<p class="description">
			<?php echo __( 'Crear una orden al seleccionar botón de continuar.', PLUGIN_SLUG ); ?>
			<br>
			<small><?php echo __( 'Se pedirá de manera opcional el nombre completo, teléfono y correo electrónico al cliente.', PLUGIN_SLUG ); ?></small>
		</p>
		<?php
	}
}

if ( !function_exists( 'woocommerce_cart_estimations_set_customer_name_mandatory_callback' ) ) {
	/**
	 * Render controls to update 'set_customer_name_mandatory' settings option.
	 */
	function woocommerce_cart_estimations_set_customer_name_mandatory_callback() {
		$options = get_option( 'woocommerce_cart_estimations_options' );
		$checked = ( isset( $options['set_customer_name_mandatory'] ) ) ? checked( true, boolval( $options['set_customer_name_mandatory'] ), false ) : '';
		$disabled = ! isset( $options['create_order_after_chekout'] ) ? 'disabled' : '';
		?>
		<input
			type="checkbox"
			name="woocommerce_cart_estimations_options[set_customer_name_mandatory]"
			id="woocommerce_cart_estimations_options[set_customer_name_mandatory]"
			<?php echo esc_html( $checked ); ?>
			<?php echo esc_html( $disabled); ?>
		>
		<p class="description">
			<small>
				<?php
				echo __(
					'Al generar una order se le requerira o no al cliente que ingrese su nombre completo.',
					PLUGIN_SLUG
				);
				?>
			</small>
		</p>
		<?php
	}
}

if ( !function_exists( 'woocommerce_cart_estimations_set_customer_phone_mandatory_callback' ) ) {
	/**
	 * Render controls to update 'set_customer_phone_mandatory' settings option.
	 */
	function woocommerce_cart_estimations_set_customer_phone_mandatory_callback() {
		$options = get_option( 'woocommerce_cart_estimations_options' );
		$checked = ( isset( $options['set_customer_phone_mandatory'] ) ) ? checked( true, boolval( $options['set_customer_phone_mandatory'] ), false ) : '';
		$disabled = ! isset( $options['create_order_after_chekout'] ) ? 'disabled' : '';
		?>
		<input
			type="checkbox"
			name="woocommerce_cart_estimations_options[set_customer_phone_mandatory]"
			id="woocommerce_cart_estimations_options[set_customer_phone_mandatory]"
			<?php echo esc_html( $checked ); ?>
			<?php echo esc_html( $disabled); ?>
		>
		<p class="description">
			<small>
				<?php
				echo __(
					'Al generar una order se le requerira o no al cliente que ingrese su número de teléfono.',
					PLUGIN_SLUG
				);
				?>
			</small>
		</p>
		<?php
	}
}

if ( !function_exists( 'woocommerce_cart_estimations_set_customer_email_mandatory_callback' ) ) {
	/**
	 * Render controls to update 'set_customer_email_mandatory' settings option.
	 */
	function woocommerce_cart_estimations_set_customer_email_mandatory_callback() {
		$options = get_option( 'woocommerce_cart_estimations_options' );
		$checked = ( isset( $options['set_customer_email_mandatory'] ) ) ? checked( true, boolval( $options['set_customer_email_mandatory'] ), false ) : '';
		$disabled = ! isset( $options['create_order_after_chekout'] ) ? 'disabled' : '';
		?>
		<input
			type="checkbox"
			name="woocommerce_cart_estimations_options[set_customer_email_mandatory]"
			id="woocommerce_cart_estimations_options[set_customer_email_mandatory]"
			<?php echo esc_html( $checked ); ?>
			<?php echo esc_html( $disabled); ?>
		>
		<p class="description">
			<small>
				<?php
				echo __(
					'Al generar una order se le requerira o no al cliente que ingrese su correo electrónico.',
					PLUGIN_SLUG
				);
				?>
			</small>
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
		$full_name_required = ( isset($options['set_customer_name_mandatory'] ) ) ? 'required':'';
		$email_required = ( isset($options['set_customer_email_mandatory'] ) ) ? 'required':'';
		$phone_required = ( isset($options['set_customer_phone_mandatory'] ) ) ? 'required':'';

		if ( isset( $options['create_order_after_chekout'] ) && boolval( $options['create_order_after_chekout'] ) ) : ?>
			<div class="woocommerce-billing-fields">
				<h4>
					<?php echo __( 'Dejanos conocerte', PLUGIN_SLUG); ?>
				</h4>
				<div class="woocommerce-billing-fields__field-wrapper">
					<table>
						<tr>
							<td>
								<label for="billing_first_name" class="">
									<?php echo __( 'Nombre completo:', PLUGIN_SLUG); ?>
								</label>
							</td>
							<td>
								<span class="woocommerce-input-wrapper">
									<input type="text" class="input-text <?= $full_name_required ?>" name="billing_first_name" id="billing_first_name" placeholder="<?php echo __( 'Nombre completo', PLUGIN_SLUG); ?>" value="" >
								</span>
							</td>
						</tr>
						<tr>
							<td>
								<label for="billing_phone" class="">
									<?php echo __( 'Teléfono:', PLUGIN_SLUG); ?>
								</label>
							</td>
							<td>
								<span class="woocommerce-input-wrapper">
									<input type="tel" class="input-text <?= $phone_required ?>" name="billing_phone" id="billing_phone" placeholder="<?php echo __( 'Teléfono', PLUGIN_SLUG); ?>" value="" autocomplete="tel">
								</span>
							</td>
						</tr>
						<tr>
							<td>
								<label for="billing_email" class="">
									<?php echo __( 'Correo electrónico:', PLUGIN_SLUG); ?>
								</label>
							</td>
							<td>
								<span class="woocommerce-input-wrapper">
									<input type="email" class="input-text <?= $email_required ?>" name="billing_email" id="billing_email" placeholder="<?php echo __( 'Correo electrónico', PLUGIN_SLUG); ?>" value="" autocomplete="email">
								</span>
							</td>
						</tr>
					</table>
				</div>
			</div>
		<?php endif; ?>
        <a id="woocommerce_cart_estimations_checkout_button" class="checkout-button button alt wc-forward">
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
				if ( boolval( $options['create_order_after_chekout'] ) ){
					// Create order.
					woocomerce_cart_estimations_create_order_from_cart();
				}
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

if ( ! function_exists( 'woocommerce_cart_estimations_create_pdf' ) ) {
	/**
	 * Function to create pdf estimation file from cart contents.
	 *
	 * @since  1.0.0
	 * @param  string $file_name The name of the output file, by default will be the post name.
	 * @return string The pdf file url if success or error message.
	 */
	function woocommerce_cart_estimations_create_pdf( $file_name = '' ) {
		ob_clean();
		ob_start();
		?>
		<div class="pdf-container">
			<div >
				<div class="pdf-first-page-title">
					<P>
						<?php _e( 'File title', PLUGIN_SLUG ); ?>
					</P>
				</div><!-- title -->
				<div class="pdf-first-page-subtitle">
					<P>
						<?php _e( 'File subtitle', PLUGIN_SLUG ); ?>
					</P>
				</div><!-- subtitle -->
				<div class="pdf-first-page-date">
					<?php
					$date = date_create();
					echo esc_html( date_format( $date, 'd | m | y' ) ); ?>
				</div><!--  .due date -->
			</div>
			<table class="pdf-table-container">
				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item) :
					$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) {
						echo sprintf(
							'<tr><td class="thumbnail">%s</td><td class="name"></td><td class="price"></td><td class="quantity"></td></tr><td class="subtotal"></td>',
							$_product->get_image('thumbnail'),
							$_product->get_name(),
							wc_price($_product->get_price()),
							woocommerce_quantity_input(
								array(
									'input_name'    => "cart[{$cart_item_key}][qty]",
									'input_value'   => $cart_item['quantity'],
									'max_value'     => $_product->get_max_purchase_quantity(),
									'min_value'     => '0',
									'product_name'  => $_product->get_name(),
								),
								$_product,
								false
							),
							wc_price( WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ) ) 
						);
					}
				endforeach;
				?>
			</table>
		</div>
		<?php
		$output = ob_get_clean();

		$root_path          = plugin_dir_path( __FILE__ );
		$autoload_file_path = $root_path . 'lib/vendor/autoload.php';
		$pdf_path           = $root_path . 'public/pdfs/';

		if ( file_exists( $autoload_file_path ) ) :
			include_once $autoload_file_path;
			$dompdf = new Dompdf\Dompdf();
			$dompdf->loadHtml( $output );
			$dompdf->setPaper( 'letter', 'portrait' );
			$dompdf->render();
			$pdf_output = $dompdf->output();
			$file_name = ( '' !== $file_name ) ? $file_name : time();
			$full_file_path = $pdf_path . $file_name . '.pdf';

			if ( ! is_dir( $pdf_path ) ) :
				mkdir( $pdf_path, 0755, true );
			endif;

			if ( file_exists( $full_file_path ) ) :
				unlink( $full_file_path );
			endif;

			if ( file_put_contents(
				$full_file_path,
				$pdf_output
			) ) :
				return plugin_dir_url( __FILE__ ) . 'public/pdfs/' . $file_name . '.pdf';
			endif;
		endif;
		return false;
	}
}

if ( !function_exists( 'woocomerce_cart_estimations_create_order_from_cart' ) ) {
	/**
	 * Function to create a Woocommerce order from current cart content.
	 * 
	 * @param string $customer_full_name Customer data.
	 * @param string $customer_email Customer data.
	 * @param string $customer_phone Customer data.
	 * 
	 * @return void
	 */
	function woocomerce_cart_estimations_create_order_from_cart( $customer_full_name = 'Anonimo', $customer_email = 'anonimo@mail.com', $customer_phone = '0000000' ) {
		// Create a new instance of the WC_Order object
		$order = wc_create_order();
	
		// Get cart contents
		$cart = WC()->cart;
		foreach ($cart->get_cart() as $cart_item_key => $cart_item) :
			$product_id = $cart_item['product_id'];
			$quantity = $cart_item['quantity'];
			$product = wc_get_product($product_id);
	
			if ($product) :
				$item = new WC_Order_Item_Product();
				$item->set_variation_id($cart_item['variation_id']);
				$item->set_product($product);
				$item->set_quantity($quantity);
				$item->set_total($product->get_price() * $quantity);
				$order->add_item($item);
			endif;
		endforeach;
	
		// Create the order.
		$order->save();
	
		// Calculate totals
		$order->calculate_totals();
		$order->save();
	
		$order->update_meta_data( '_billing_first_name', $customer_full_name );
		$order->update_meta_data( '_billing_email', $customer_email );
		$order->update_meta_data( '_billing_phone', $customer_phone );
		$order->save();
	}
}

<?php
/*
Plugin Name: WooCommerce FacturaE XML Generator
Plugin URI: https://xarop.com
Description: Genera archivos XML en formato FacturaE para los pedidos de WooCommerce.
Version: 1.0
Author: xarop.com
License: GPL2
Text Domain: wc-facturae-generator
*/

// Asegura que WooCommerce está activo
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Verificar si WooCommerce y el plugin de Facturas PDF están activos
add_action('plugins_loaded', 'wc_facturae_check_woocommerce_and_pdf_invoices');

function wc_facturae_check_woocommerce_and_pdf_invoices()
{
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', 'wc_facturae_woocommerce_inactive_notice');
    }

    if (!is_plugin_active('woocommerce-pdf-invoices-packing-slips/wpo_wcpdf.php')) {
        if (!get_option('wc_facturae_pdf_invoices_redirected', false)) {
            add_action('admin_notices', 'wc_facturae_pdf_invoices_inactive_notice');
            add_action('admin_init', 'wc_facturae_redirect_to_plugins_page');
            update_option('wc_facturae_pdf_invoices_redirected', true);
        }
    }
}

function wc_facturae_woocommerce_inactive_notice()
{
    echo '<div class="notice notice-error"><p>' . __('WooCommerce FacturaE XML Generator requiere WooCommerce activo.', 'wc-facturae-generator') . '</p></div>';
}

function wc_facturae_pdf_invoices_inactive_notice()
{
    echo '<div class="notice notice-error"><p>' . __('El plugin WooCommerce PDF Invoices & Packing Slips no está instalado o activado. Por favor, instálalo para generar las facturas en formato XML.', 'wc-facturae-generator') . '</p></div>';
}

function wc_facturae_redirect_to_plugins_page()
{
    wp_redirect(admin_url('plugins.php'));
    exit;
}


// Agregar la opción al menú de WooCommerce
add_action('admin_menu', 'wc_facturae_add_menu_page');
function wc_facturae_add_menu_page()
{
    // Añadir la página principal en el menú de WooCommerce
    add_submenu_page(
        'woocommerce',                              // Menú principal (WooCommerce)
        'FacturaE XML Generator',                   // Título de la página
        'FacturaE XML Generator',                   // Título del menú
        'manage_woocommerce',                       // Capacidad necesaria
        'wc-facturae-generator',                    // Slug
        'wc_facturae_menu_page_callback'            // Función para mostrar la página
    );
}


// Callback de la página de configuración del plugin
function wc_facturae_menu_page_callback()
{
?>
    <div class="wrap">
        <h1><?php _e('Configuración de FacturaE XML Generator', 'wc-facturae-generator'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('wc_facturae_settings_group'); // Guardar los ajustes
            do_settings_sections('wc-facturae-generator'); // Mostrar los campos
            submit_button();
            ?>
        </form>
    </div>
<?php
}

// Registramos los ajustes para la página de configuración
add_action('admin_init', 'wc_facturae_register_settings');
function wc_facturae_register_settings()
{
    // Registrar los campos de configuración
    register_setting('wc_facturae_settings_group', 'wc_facturae_company_name');
    register_setting('wc_facturae_settings_group', 'wc_facturae_company_nif');
    register_setting('wc_facturae_settings_group', 'wc_facturae_company_address');
    register_setting('wc_facturae_settings_group', 'wc_facturae_company_city');
    register_setting('wc_facturae_settings_group', 'wc_facturae_company_postcode');
    register_setting('wc_facturae_settings_group', 'wc_facturae_company_country');

    // Agregar la sección y los campos
    add_settings_section(
        'wc_facturae_settings_section',
        __('Información de la Empresa', 'wc-facturae-generator'),
        null,
        'wc-facturae-generator'
    );

    add_settings_field(
        'wc_facturae_company_name',
        __('Nombre de la Empresa', 'wc-facturae-generator'),
        'wc_facturae_company_name_field',
        'wc-facturae-generator',
        'wc_facturae_settings_section'
    );

    add_settings_field(
        'wc_facturae_company_nif',
        __('NIF de la Empresa', 'wc-facturae-generator'),
        'wc_facturae_company_nif_field',
        'wc-facturae-generator',
        'wc_facturae_settings_section'
    );

    add_settings_field(
        'wc_facturae_company_address',
        __('Dirección de la Empresa', 'wc-facturae-generator'),
        'wc_facturae_company_address_field',
        'wc-facturae-generator',
        'wc_facturae_settings_section'
    );

    add_settings_field(
        'wc_facturae_company_city',
        __('Ciudad de la Empresa', 'wc-facturae-generator'),
        'wc_facturae_company_city_field',
        'wc-facturae-generator',
        'wc_facturae_settings_section'
    );

    add_settings_field(
        'wc_facturae_company_postcode',
        __('Código Postal de la Empresa', 'wc-facturae-generator'),
        'wc_facturae_company_postcode_field',
        'wc-facturae-generator',
        'wc_facturae_settings_section'
    );

    add_settings_field(
        'wc_facturae_company_country',
        __('País de la Empresa', 'wc-facturae-generator'),
        'wc_facturae_company_country_field',
        'wc-facturae-generator',
        'wc_facturae_settings_section'
    );
}

// Funciones para mostrar los campos de configuración
function wc_facturae_company_name_field()
{
    $value = get_option('wc_facturae_company_name', '');
    echo '<input type="text" name="wc_facturae_company_name" value="' . esc_attr($value) . '" class="regular-text" />';
}

function wc_facturae_company_nif_field()
{
    $value = get_option('wc_facturae_company_nif', '');
    echo '<input type="text" name="wc_facturae_company_nif" value="' . esc_attr($value) . '" class="regular-text" />';
}

function wc_facturae_company_address_field()
{
    $value = get_option('wc_facturae_company_address', '');
    echo '<input type="text" name="wc_facturae_company_address" value="' . esc_attr($value) . '" class="regular-text" />';
}

function wc_facturae_company_city_field()
{
    $value = get_option('wc_facturae_company_city', '');
    echo '<input type="text" name="wc_facturae_company_city" value="' . esc_attr($value) . '" class="regular-text" />';
}

function wc_facturae_company_postcode_field()
{
    $value = get_option('wc_facturae_company_postcode', '');
    echo '<input type="text" name="wc_facturae_company_postcode" value="' . esc_attr($value) . '" class="regular-text" />';
}

function wc_facturae_company_country_field()
{
    $value = get_option('wc_facturae_company_country', '');
    echo '<input type="text" name="wc_facturae_company_country" value="' . esc_attr($value) . '" class="regular-text" />';
}

// Agregar la opción de descarga en la página de pedidos
add_action('woocommerce_admin_order_actions', 'wc_facturae_add_xml_button', 10, 2);
function wc_facturae_add_xml_button($actions, $order)
{
    $actions['generate_facturae'] = array(
        'url'  => wp_nonce_url(admin_url('admin-ajax.php?action=generate_facturae_xml&order_id=' . $order->get_id()), 'generate_facturae_xml'),
        'name' => __('Descargar XML FacturaE', 'wc-facturae-generator') . ' <span class="dashicons dashicons-media-code"></span>',
        'action' => 'view'
    );
    return $actions;
}

// Procesar la generación del XML
add_action('wp_ajax_generate_facturae_xml', 'wc_facturae_generate_xml');
function wc_facturae_generate_xml()
{
    if (!isset($_GET['order_id']) || !wp_verify_nonce($_GET['_wpnonce'], 'generate_facturae_xml')) {
        wp_die(__('Acceso no autorizado.', 'wc-facturae-generator'));
    }

    $order_id = intval($_GET['order_id']);
    $order = wc_get_order($order_id);

    if (!$order) {
        wp_die(__('Pedido no encontrado.', 'wc-facturae-generator'));
    }

    $xml = wc_facturae_generate_facturae_xml($order);

    header('Content-Type: application/xml; charset=utf-8');
    header('Content-Disposition: attachment; filename="facturae-' . $order_id . '.xml"');
    echo $xml;
    exit;
}

// Función para generar el XML FacturaE
function wc_facturae_generate_facturae_xml($order)
{
    try {
        $xml = new SimpleXMLElement('<Facturae></Facturae>');

        // Header de la factura
        $header = $xml->addChild('Header');
        $header->addChild('IssueDate', $order->get_date_created()->date('Y-m-d'));

        // Obtener el número de factura de WPO_WCPDF o ID de la orden
        $invoice_number = get_post_meta($order->get_id(), '_wcpdf_invoice_number', true);
        $header->addChild('InvoiceNumber', $invoice_number ? $invoice_number : $order->get_id());

        // Obtener los datos de la empresa
        $company_info = wc_facturae_get_company_info();

        // Añadir la información de la empresa al XML
        $header->addChild('Seller', $company_info['name']);
        $header->addChild('SellerNIF', $company_info['nif']);
        $header->addChild('SellerAddress', $company_info['address']);
        $header->addChild('SellerCity', $company_info['city']);
        $header->addChild('SellerPostalCode', $company_info['postcode']);
        $header->addChild('SellerCountry', $company_info['country']);

        // Información del cliente
        $buyer = $xml->addChild('BuyerData');
        $buyer->addChild('Name', $order->get_billing_first_name() . ' ' . $order->get_billing_last_name());
        $buyer->addChild('NIF', $order->get_billing_company());
        $buyer->addChild('Address', $order->get_billing_address_1());
        $buyer->addChild('City', $order->get_billing_city());
        $buyer->addChild('PostalCode', $order->get_billing_postcode());
        $buyer->addChild('Country', $order->get_billing_country());

        // Líneas de la factura (productos)
        $lines = $xml->addChild('InvoiceLines');
        foreach ($order->get_items() as $item_id => $item) {
            $line = $lines->addChild('Line');
            $line->addChild('LineNumber', $item_id);
            $line->addChild('ProductName', $item->get_name());
            $line->addChild('Quantity', $item->get_quantity());
            $line->addChild('UnitPrice', $item->get_total() / $item->get_quantity());
            $line->addChild('TotalLineAmount', $item->get_total());
        }

        // Total de la factura
        $totals = $xml->addChild('Totals');
        $totals->addChild('Subtotal', $order->get_subtotal());
        $totals->addChild('Tax', $order->get_total_tax());
        $totals->addChild('Total', $order->get_total());

        return $xml->asXML();
    } catch (Exception $e) {
        error_log('Error en la generación del XML: ' . $e->getMessage());
        wp_die('Error al generar el XML: ' . $e->getMessage());
    }
}

// Función para obtener la información de la empresa
function wc_facturae_get_company_info()
{
    return array(
        'name' => get_option('wc_facturae_company_name', 'Mi Empresa'),
        'nif' => get_option('wc_facturae_company_nif', '12345678A'),
        'address' => get_option('wc_facturae_company_address', 'Calle Ficticia, 123'),
        'city' => get_option('wc_facturae_company_city', 'Ciudad Ejemplo'),
        'postcode' => get_option('wc_facturae_company_postcode', '28000'),
        'country' => get_option('wc_facturae_company_country', 'ES')
    );
}
?>
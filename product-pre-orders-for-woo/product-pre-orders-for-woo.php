<?php
/**
 * Plugin Name: Product Pre-Orders for Woocommerce
 * Plugin URI: https://villatheme.com/extensions/woocommerce-product-pre-orders/
 * Description: Easily set up your store to accept orders for unreleased products, allowing customers to purchase items in advance.
 * Version: 1.2.5
 * Author: VillaTheme
 * Author URI: https://villatheme.com
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0
 * Copyright 2021-2024 VillaTheme.com. All rights reserved.
 * Requires Plugins: woocommerce
 * Text Domain: product-pre-orders-for-woo
 * Requires at least: 5.0
 * Tested up to: 6.5
 * WC requires at least: 7.0
 * WC tested up to: 9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'WPRO_WOO_PRE_ORDER_VERSION', '1.2.5' );
define( 'WPRO_WOO_PRE_ORDER_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPRO_WOO_PRE_ORDER_URL', plugin_dir_url( __FILE__ ) );

/**
 * Detect plugin. For use on Front End only.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Class WPRO_WOO_PRE_ORDER
 */
if ( ! class_exists( 'WPRO_WOO_PRE_ORDER' ) ) {
    class WPRO_WOO_PRE_ORDER {
        
        public function __construct() {
            add_action( 'plugins_loaded', array( $this, 'check_environment' ) );
            //compatible with 'High-Performance order storage (COT)'
            add_action( 'before_woocommerce_init', array( $this, 'before_woocommerce_init' ) );
        }
        
        public function before_woocommerce_init() {
            if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
                \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
            }
        }
        
        public function check_environment() {
            if ( ! class_exists( 'VillaTheme_Require_Environment' ) ) {
                include_once WPRO_WOO_PRE_ORDER_DIR . 'includes/support.php';
            }
            
            $environment = new \VillaTheme_Require_Environment( [
                'plugin_name'     => 'Product Pre-Orders for Woocommerce',
                'php_version'     => '7.0',
                'wp_version'      => '5.0',
                'wc_version'      => '7.0',
                'require_plugins' => [
                    [
                        'slug' => 'woocommerce',
                        'name' => 'WooCommerce',
                    ],
                ],
            ] );
            
            if ( $environment->has_error() ) {
                return;
            }
            
            $data_init = array(
                'enabled'              => 'yes',
                'price_calculation'    => 'yes',
                'default_label_simple' => 'Pre-Order Now',
                'no_date_text'         => 'Comming Soon...',
                'date_text'            => 'Available on: {availability_date} at {availability_time}',
                'label_variable'       => 'Select Options',
                'color_date_cart'      => '#a46497',
                'color_date_single'    => '#00a79c',
                'color_date_shop_page' => '#b20015',
            );
            
            if ( ! get_option( 'pre_order_setting_default', '' ) ) {
                update_option( 'pre_order_setting_default', $data_init );
            }
            
            require( WPRO_WOO_PRE_ORDER_DIR . 'includes/define.php' );
        }
        
    }
}

new WPRO_WOO_PRE_ORDER();
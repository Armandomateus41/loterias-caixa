<?php
/**
 * Plugin Name: Loterias Caixa
 * Author: Armando Capita
 * Description: Plugin que exibe os resultados dos jogos das Loterias Caixa.
 * Version: 1.0.0
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit;
}

define('LOT_CX_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('LOT_CX_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once LOT_CX_PLUGIN_DIR . 'class-loterias-caixa.php';
require_once LOT_CX_PLUGIN_DIR . 'class-loterias-api.php';

function lot_cx_init() {
    Loterias_Caixa::get_instance();
}
add_action('plugins_loaded', 'lot_cx_init');

function lot_cx_enqueue_scripts() {
    wp_enqueue_style('loterias-style', LOT_CX_PLUGIN_URL . 'assets/css/style.css');
}
add_action('wp_enqueue_scripts', 'lot_cx_enqueue_scripts');

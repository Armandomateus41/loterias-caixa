<?php

class Loterias_Caixa {
    private static $instance = null;

    private function __construct() {
        add_action('init', [$this, 'register_post_type']);
        add_shortcode('loterias', [$this, 'render_shortcode']);
        add_action('plugins_loaded', [$this, 'load_textdomain']);
    }

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function register_post_type() {
        register_post_type('loterias', [
            'labels' => [
                'name' => __('Loterias', 'loterias-caixa'),
                'singular_name' => __('Loteria', 'loterias-caixa')
            ],
            'public' => true,
            'has_archive' => true,
            'supports' => ['title', 'editor'],
            'rewrite' => ['slug' => 'loterias'],
        ]);
    }

    public function load_textdomain() {
        load_plugin_textdomain('loterias-caixa', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    public function render_shortcode($atts) {
        $atts = shortcode_atts([
            'loteria' => 'megasena',
            'concurso' => 'latest',
        ], $atts, 'loterias');

        $api = new Loterias_API();
        
        $results = $api->get_results($atts['loteria'], $atts['concurso']);

        if (empty($results) || !isset($results['dezenas'])) {
            return __('Nenhum resultado encontrado.', 'loterias-caixa');
        }

        ob_start();
        ?>
        <div class="loteria-result">
            <h2><?php echo esc_html('Resultado ' . $results['loteria']) ?>: <?php echo esc_html($results['concurso']) ?></h2>
            <p><?php echo esc_html($results['data']) ?></p>
            <div class="loteria-numeros">
                <?php foreach ($results['dezenas'] as $numero): ?>
                    <span class="numero"><?php echo esc_html($numero) ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

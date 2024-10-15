<?php

class Loterias_API {
    const API_URL = 'https://loteriascaixa-api.herokuapp.com/api';

    public function get_results($loteria, $concurso = 'latest') {
        $cache_key = "loteria_{$loteria}_{$concurso}";
        $cached_data = get_transient($cache_key);

        if (false !== $cached_data) {
            return $cached_data;
        }

        $url = self::API_URL . "/{$loteria}/{$concurso}";

        $response = wp_remote_get($url);
        if (is_wp_error($response) || 200 != wp_remote_retrieve_response_code($response)) {
            return [];
        }

        $data = json_decode(wp_remote_retrieve_body($response), true);

        set_transient($cache_key, $data, 3600);  // Cache por 1 hora

        return $data;
    }
}

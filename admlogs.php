<?php
/*
Plugin Name: AdmLogs
Description: Um plugin para registrar e exibir informações de acesso.
Version: 1.5
Author: Felype Kravetz
*/

// Função para criar a tabela no banco de dados
function criar_tabela_acessos() {
    global $wpdb;

    $tabela_acessos = $wpdb->prefix . 'admlogs_acessos';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $tabela_acessos (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        data_hora datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        ip varchar(45) NOT NULL,
        pagina_acessada varchar(255) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Chama a função de criação da tabela quando o plugin é ativado
register_activation_hook(__FILE__, 'criar_tabela_acessos');

// Função para obter o endereço IP do visitante
function get_ip_address() {
    // Verifica se é um proxy
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

// Modifica a função para registrar o acesso
function registrar_acesso() {
    global $wpdb;

    $tabela_acessos = $wpdb->prefix . 'admlogs_acessos';

    $data_hora = current_time('mysql');
    $ip = get_ip_address();
    $pagina_acessada = $_SERVER['REQUEST_URI'];

    $wpdb->insert(
        $tabela_acessos,
        array(
            'data_hora' => $data_hora,
            'ip' => $ip,
            'pagina_acessada' => $pagina_acessada
        )
    );
}

// Adiciona a função de registro aos ganchos do WordPress
add_action('wp', 'registrar_acesso');


// Função para exibir o dashboard
function exibir_dashboard() {
    global $wpdb;

    $tabela_acessos = $wpdb->prefix . 'admlogs_acessos';

    $resultados = $wpdb->get_results("SELECT * FROM $tabela_acessos ORDER BY data_hora DESC LIMIT 10");

    echo '<div class="wrap">';
    echo '<h1>Dashboard AdmLogs</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>ID</th><th>Data e Hora</th><th>IP</th><th>Página Acessada</th></tr></thead>';
    echo '<tbody>';

    foreach ($resultados as $resultado) {
        echo '<tr>';
        echo '<td>' . esc_html($resultado->id) . '</td>';
        echo '<td>' . esc_html($resultado->data_hora) . '</td>';
        echo '<td>' . esc_html($resultado->ip) . '</td>';
        echo '<td>' . esc_html($resultado->pagina_acessada) . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
    echo '</div>';
}

// Adiciona uma página ao menu do WordPress para exibir o dashboard
function adicionar_pagina_dashboard() {
    add_menu_page('AdmLogs Dashboard', 'AdmLogs', 'manage_options', 'admlogs_dashboard', 'exibir_dashboard');
}

add_action('admin_menu', 'adicionar_pagina_dashboard');
?>

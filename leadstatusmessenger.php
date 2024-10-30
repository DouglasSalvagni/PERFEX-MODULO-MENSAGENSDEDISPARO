<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Lead Status Messenger
Description: Módulo para enviar mensagens baseadas no status do lead.
Version: 1.0.0
Author: Seu Nome
*/


define('LEADSTATUSMESSENGER_MODULE_NAME', 'leadstatusmessenger');

$CI = &get_instance();

// Registrar o hook de ativação do módulo
register_activation_hook(LEADSTATUSMESSENGER_MODULE_NAME, 'lead_status_messenger_module_activation_hook');

// Função chamada ao ativar o módulo
function lead_status_messenger_module_activation_hook()
{
    // Incluir o arquivo de instalação
    require_once(__DIR__ . '/install.php');
}

// Registrar o hook de desativação do módulo
register_deactivation_hook(LEADSTATUSMESSENGER_MODULE_NAME, 'lead_status_messenger_module_deactivation_hook');

function lead_status_messenger_module_deactivation_hook()
{
    $CI = &get_instance();
    $CI->load->dbforge();
    $CI->dbforge->drop_table(db_prefix() . 'lead_status_messages', true);
}


hooks()->add_action('admin_init', 'my_module_init_menu_items');

function my_module_init_menu_items(){
    $CI = &get_instance();

    $CI->app_menu->add_sidebar_menu_item('leadstatusmessenger-menu', [
        'name'     => 'Teste',
        'href'     => base_url('admin/leadstatusmessenger'),
        'position' => 10,
        'icon'     => 'fa fa-cog menu-icon', 
    ]);
}
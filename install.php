<?php

defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

// Verificar se a tabela já existe
if (!$CI->db->table_exists(db_prefix() . 'lead_status_messages')) {
    // Criar a tabela
    $CI->db->query('CREATE TABLE `' . db_prefix() . "lead_status_messages` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `status_id` INT(11) NOT NULL,
        `message` TEXT NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`status_id`) REFERENCES `" . db_prefix() . "leads_status`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}


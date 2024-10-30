<?php

defined('BASEPATH') or exit('No direct script access allowed');

$config['migration_enabled'] = true;
$config['migration_type'] = 'timestamp';
// $config['migration_table'] = 'migrations_lead_status_messenger';
$config['migration_auto_latest'] = false;
$config['migration_version'] = 0;
$config['migration_path'] = APP_MODULES_PATH . 'LeadStatusMessenger/migrations/';

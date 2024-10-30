<?php
defined('BASEPATH') or exit('No direct script access allowed');
var_dump($route);
$route['leadstatusmessenger'] = "leadstatusmessenger/index";
$route['leadstatusmessenger/(:any)'] = "leadstatusmessenger/$1";

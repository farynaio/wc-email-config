<?php

defined( 'ABSPATH' ) || exit;

$config = [
  'smtp_host' => '',
  'smtp_auth' => true,
  'smtp_port' => '25',
  'smtp_secure' => 'tls',
  'smtp_username' => '',
  'smtp_password' => '',
  'smtp_from' => '',
  'smtp_fromname' => '',
  'debug_level' => 0
];

$config_bounce = [
  'smtp_host' => '',
  'smtp_auth' => true,
  'smtp_port' => '25',
  'smtp_secure' => 'tls',
  'smtp_username' => '',
  'smtp_password' => '',
  'smtp_from' => '',
  'smtp_fromname' => 'Bounce',
  'debug_level' => 0
];

?>
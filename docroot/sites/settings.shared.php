<?php

$domain = basename($site_path);
$settings['install_profile'] = 'minimal';
$config_directories['sync'] = '../config/'. str_replace('.dd','', $domain) . '/sync';


// Assumes database names correspond to first section of $site_path.
$db_name = current(explode('.', $domain));
if (file_exists('/var/www/site-php')) {
  // For Acquia Cloud.
  require "/var/www/site-php/mf8/$db_name-settings.inc";
}
else {
  $databases['default']['default'] = array (
    'database' => $db_name. '_massforms8_mass_gov',
    'username' => 'massforms8',
    'password' => '',
    'prefix' => '',
    'host' => 'localhost',
//  'port' => '33067',
    'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
    'driver' => 'mysql',
  );
}


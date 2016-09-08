<?php

$settings['install_profile'] = 'minimal';
// Get an identifier for the current multisite, stripped of dev desktop suffix.
$clean_site_name = str_replace('.dd','', basename($site_path));

$config_directories['sync'] = '../config/'. $clean_site_name . '/sync';

if (isset($_ENV['AH_SITE_ENVIRONMENT'])) {
  $files_private_conf_path = conf_path();
  $settings['file_private_path'] = '/mnt/files/' . $_ENV['AH_SITE_GROUP'] . '.' . $_ENV['AH_SITE_ENVIRONMENT'] . '/' . $files_private_conf_path . '/files-private';
}
else {
  $settings['file_private_path'] = '../files-private/' . $clean_site_name;
}


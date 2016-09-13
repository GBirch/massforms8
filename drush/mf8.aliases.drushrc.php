<?php

if (!isset($drush_major_version)) {
  $drush_version_components = explode('.', DRUSH_VERSION);
  $drush_major_version = $drush_version_components[0];
}
// Site mf8, environment dev
$aliases['dev'] = array(
  'root' => '/var/www/html/mf8.dev/docroot',
  'ac-site' => 'mf8',
  'ac-env' => 'dev',
  'ac-realm' => 'devcloud',
  'uri' => 'mf8ryjdnclyfu.devcloud.acquia-sites.com',
  'remote-host' => 'free-5957.devcloud.hosting.acquia.com',
  'remote-user' => 'mf8.dev',
  'path-aliases' => array(
    '%drush-script' => 'drush' . $drush_major_version,
  )
);
$aliases['dev.livedev'] = array(
  'parent' => '@mf8.dev',
  'root' => '/mnt/gfs/mf8.dev/livedev/docroot',
);

if (!isset($drush_major_version)) {
  $drush_version_components = explode('.', DRUSH_VERSION);
  $drush_major_version = $drush_version_components[0];
}
// Site mf8, environment test
$aliases['test'] = array(
  'root' => '/var/www/html/mf8.test/docroot',
  'ac-site' => 'mf8',
  'ac-env' => 'test',
  'ac-realm' => 'devcloud',
  'uri' => 'mf8w2futneyk5.devcloud.acquia-sites.com',
  'remote-host' => 'free-5957.devcloud.hosting.acquia.com',
  'remote-user' => 'mf8.test',
  'path-aliases' => array(
    '%drush-script' => 'drush' . $drush_major_version,
  )
);
$aliases['test.livedev'] = array(
  'parent' => '@mf8.test',
  'root' => '/mnt/gfs/mf8.test/livedev/docroot',
);

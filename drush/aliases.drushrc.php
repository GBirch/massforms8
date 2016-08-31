<?php

$root['root'] = dirname(__DIR__). '/web';

$aliases['demo'] = $root + array(
  'uri' => 'http://demo.massforms8.mass.gov/',
);

// Adjust alias for local configuration as needed.
if (file_exists(__DIR__ . '/aliases.local.php')) {
  include __DIR__ . '/aliases.local.php';
}
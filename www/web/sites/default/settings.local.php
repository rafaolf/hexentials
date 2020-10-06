<?php

if (getenv('LANDO') === 'ON') {
  $settings['trusted_host_patterns'] = ['.*'];
  $settings['hash_salt'] = md5(getenv('LANDO_HOST_IP'));

  // Configuration setup.
  $config['config_split.config_split.dev']['status'] = TRUE;

  $lando_info = json_decode(getenv('LANDO_INFO'), TRUE);
  $databases['default']['default'] = [
    'driver' => 'mysql',
    'database' => $lando_info['database']['creds']['database'],
    'username' => $lando_info['database']['creds']['user'],
    'password' => $lando_info['database']['creds']['password'],
    'host' => $lando_info['database']['internal_connection']['host'],
    'port' => $lando_info['database']['internal_connection']['port'],
  ];

  // Include development services file.
  $settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';

  // Make error logging more verbose.
  $config['system.logging']['error_level'] = 'verbose';

  // Disable minification of CSS and JS.
  $config['system.performance']['css']['preprocess'] = FALSE;
  $config['system.performance']['js']['preprocess'] = FALSE;

  // Disable caches.
  $settings['cache']['bins']['render'] = 'cache.backend.null';
  $settings['cache']['bins']['page'] = 'cache.backend.null';
  $settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';
  $settings['cache']['default'] = 'cache.backend.null';

  // Allow access to rebuild.PHP.
  $settings['rebuild_access'] = TRUE;

  // Do not let Drupal change permissions on files.
  $settings['skip_permissions_hardening'] = TRUE;
}

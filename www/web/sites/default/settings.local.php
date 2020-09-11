<?php

if (getenv('LANDO') === 'ON') {
  $settings['trusted_host_patterns'] = ['.*'];
  $settings['hash_salt'] = md5(getenv('LANDO_HOST_IP'));
  $settings["config_sync_directory"] = 'config/dev';

  $lando_info = json_decode(getenv('LANDO_INFO'), TRUE);
  $databases['default']['default'] = [
    'driver' => 'mysql',
    'database' => $lando_info['database']['creds']['database'],
    'username' => $lando_info['database']['creds']['user'],
    'password' => $lando_info['database']['creds']['password'],
    'host' => $lando_info['database']['internal_connection']['host'],
    'port' => $lando_info['database']['internal_connection']['port'],
  ];
}

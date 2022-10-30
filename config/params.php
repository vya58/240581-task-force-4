<?php

$config = parse_ini_file('/OpenServ/domains/config/taskforce_config.ini', true);

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'geocoderKey' => $config['geocoder_key'],
];

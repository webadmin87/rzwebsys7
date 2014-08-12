<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'mailFrom' => 'admin@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'cacheDuration' => '7200',
    // Главный модуль (main) должен подключаться последним, воизбежании проблем с роутингом
    'enabledModules' => ['news', 'main'],
];

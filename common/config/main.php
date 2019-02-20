<?php
return [
    'language' => 'ru',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'Asia/Novosibirsk',
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'admins' => ['admin'],
            'mailer' => [
                'sender'                => ['support@lacorsashop.ru' => 'Lacorsa'], // or ['no-reply@myhost.com' => 'Sender name']
                'welcomeSubject'        => 'Спасибо за регистрацию!',
                'confirmationSubject'   => 'Подтверждение учетной записи',
                'reconfirmationSubject' => 'Изменение Email',
                'recoverySubject'       => 'Восстановление пароля',
            ],
        ],
    ],
];

<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'cart' => [
            'class' => 'frontend\models\MyShoppingCart',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'sale/<categorySlug:\w+>' => 'catalog/sale',
                'catalog/<categorySlug:\w+>' => 'catalog/catalog',
                'catalog/<categorySlug:\w+>/<productId:\d+>' => 'catalog/product',
                'cart' => 'cart/cart',
                'contact' => 'site/contact',
                'shipping' => 'site/shipping',
                'wholesale' => 'site/wholesale',
                'certificate' => 'site/certificate',
                'franchise' => 'site/franchise',
            ],
        ],
    ],
    'params' => $params,
];

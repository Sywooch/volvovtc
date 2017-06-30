<?php

use yii\web\UrlNormalizer;

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'slkjowieu4]nbfvxcmvbsdklh928345;_324dfsagqer+ert-p',
            'baseUrl' => ''
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
			'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                // use temporary redirection instead of permanent for debugging
                'action' => UrlNormalizer::ACTION_REDIRECT_TEMPORARY,
            ],
            'rules' => [
                '' => 'site/index',

                // mods
                'modifications/<game:\w+>/<category:\w+>/<subcategory:\w+>/' => 'site/modifications',
                'modifications/<id:\d+>/<action:\w+>/' => 'site/modifications',
                'modifications/<game:\w+>/<category:\w+>/' => 'site/modifications',
                'modifications/<action:\w+>/' => 'site/modifications',

                // members
                'members/<id:\d+>/<action:\w+>/' => 'site/members',
                'members/<action:\w+>/' => 'site/members',

                // profile
                'profile/<id:\d+>/' => 'site/profile',
                'profile/<action:\w+>/' => 'site/profile',

                // convoys
                'convoys/<id:\d+>/<action:\w+>/' => 'site/convoys',
                'convoys/<id:\d+>/' => 'site/convoys',
                'convoys/<action:\w+>/' => 'site/convoys',

                // news
                'news/<id:\d+>/<action:\w+>/' => 'site/news',
                'news/<id:\d+>/' => 'site/news',
                'news/<action:\w+>/' => 'site/news',

                // claims
                'claims/<id:\d+>/<claim:\w+>/<action:\w+>/' => 'site/claims',
                'claims/<claim:\w+>/<action:\w+>/' => 'site/claims',

                // rules
                'rules/<action:\w+>/' => 'site/rules',

                // trailers
                'trailers/<action:\w+>/<id:\d+>/' => 'site/trailers',
                'trailers/<action:\w+>/' => 'site/trailers',

                // general
                '<action:\w+>/<id:\d+>/' => 'site/<action>',
                '<action>/page/<page:\d+>/' => 'site/<action>',
                '<action>' => 'site/<action>',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
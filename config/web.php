<?php

use yii\web\UrlNormalizer;

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
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

                // achievements
                'achievements' => 'achievements/index',
                'achievements/<action:\w+>/<id:\d+>/<operation:\w+>' => 'achievements/<action>',
                'achievements/<action:\w+>/<id:\d+>' => 'achievements/<action>',
                'achievements/<action:\w+>' => 'achievements/<action>',

                // appeals
                'appeals/page/<page:\d+>/' => 'appeals/index',
                'appeals' => 'appeals/index',
                'appeals/<action:\w+>/<id:\d+>/' => 'appeals/<action>',
                'appeals/<action:\w+>' => 'appeals/<action>',

                // claims
                'claims/<action:\w+>/<claim:\w+>/<id:\d+>/' => 'claims/<action>',
                'claims/<action:\w+>/<claim:\w+>/' => 'claims/<action>',
                'claims' => 'claims/index',

                // convoys
                'convoys/<id:\d+>/' => 'convoys/index',
                'convoys' => 'convoys/index',
                'convoys/<action:\w+>/<id:\d+>/' => 'convoys/<action>',
                'convoys/<action:\w+>/<game:\w+>/' => 'convoys/<action>',
                'convoys/<action:\w+>/' => 'convoys/<action>',

                // members
                'members' => 'members/index',
                'members/<action:\w+>/<id:\d+>/<dir:\w+>/' => 'members/<action>',
                'members/<action:\w+>/<id:\d+>/' => 'members/<action>',
                'members/<action:\w+>/' => 'members/<action>',

                // mods
                'modifications' => 'modifications/index',
                'modifications/all/page/<page:\w+>/' => 'modifications/all',
                'modifications/<game:\w+>/<category:\w+>/<subcategory:\w+>/' => 'modifications/category',
                'modifications/<action:\w+>/<id:\d+>/' => 'modifications/<action>',
                'modifications/<game:\w+>/<category:\w+>/' => 'modifications/category',
                'modifications/<action:\w+>/' => 'modifications/<action>',

                // news
                'news/<id:\d+>/<action:\w+>/' => 'site/news',
                'news/<id:\d+>/' => 'site/news',
                'news/<action:\w+>/' => 'site/news',

                // profile
                'profile/<id:\d+>/' => 'site/profile',
                'profile/<action:\w+>/' => 'site/profile',

                // rules
                'rules/<action:\w+>/' => 'site/rules',

                // trailers
                'trailers/add' => 'trailers/add',
                'trailers/getinfo' => 'trailers/getinfo',
                'trailers/<category:\w+>/page/<page:\d+>/' => 'trailers/index',
                'trailers/page/<page:\d+>/' => 'trailers/index',
                'trailers/<category:\w+>/' => 'trailers/index',
                'trailers/<action:\w+>/<id:\d+>/' => 'trailers/<action>',
                'trailers' => 'trailers/index',
                'trailers/<action:\w+>/' => 'trailers/<action>',

                // variations
                'variations/<game:\w+>/' => 'site/variations',

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
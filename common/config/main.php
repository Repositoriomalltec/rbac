<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    /* 'modules' => [
      'mimin' => [
      'class' => '\hscstudio\mimin\Module',
      ],
      'rbac' => [
      'class' => 'common\modules\rbac\Rbac',
      ],
      ], */
    'components' => [
        'Permission' => [
            'class' => 'common\components\ModulesPermission',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    /*
      'authManager' => [
      'class' => 'yii\rbac\DbManager', // only support DbManager
      ], */
    ],
        /* 'as access' => [
          'class' => '\hscstudio\mimin\components\AccessControl',
          'allowActions' => [
          // add wildcard allowed action here!
          'site/*',
          'debug/*',
          'mimin/*', // only in dev mode
          ],
          ], */
];

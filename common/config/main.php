<?php

return [
  'aliases' => [
    '@bower' => '@vendor/bower-asset',
    '@npm' => '@vendor/npm-asset',
  ],
  'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
  'modules' => [
    'rbac' => [
      'class' => 'common\modules\rbac\Rbac',
    ],
  ],
  'components' => [
    // 'Permission' => [
      //'class' => 'common\components\ModulesPermission',
      // ],
      'cache' => [
        'class' => 'yii\caching\FileCache',
      ],
      'authManager' => [
        //'class' => 'yii\rbac\PhpManager',
        'class' => 'yii\rbac\DbManager',
      ],
    ],
  ];
  
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AuthRule */

$this->title = 'Cadastrar permissão';
$this->params['breadcrumbs'][] = ['label' => 'Permissão', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-rule-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form') ?>
</div>
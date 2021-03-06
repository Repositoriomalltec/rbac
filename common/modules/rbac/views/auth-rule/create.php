<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AuthRule */

$this->title = 'Criar regra de autenticação';
$this->params['breadcrumbs'][] = ['label' => 'Auth Rules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-rule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
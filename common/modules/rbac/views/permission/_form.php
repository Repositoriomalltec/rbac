<?php
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AuthRule */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="auth-item-create">
    <div class="auth-item-form">
        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group">
            <label for="banner-view">Comunicação
                <input type="checkbox" id="banner-view" name="banner-view">
            </label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Salvar</button> </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
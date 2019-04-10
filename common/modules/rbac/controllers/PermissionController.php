<?php

namespace common\modules\rbac\controllers;

use yii\web\Controller;

/**
 * Default controller for the `rbac` module
 */
class PermissionController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex(){
        return $this->render('index');
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionCreate(){
        return $this->render('create');
    }
}

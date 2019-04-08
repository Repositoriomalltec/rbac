<?php

/**
 * @author Prakash S
 * @copyright 2017
 */
 
namespace common\components;

use common\models\RolePermission;
use Yii;
use yii\base\Component;
use yii\helpers\Url;

class ModulesPermission extends Component{
    public function getMenus() {
        $role_id = Yii::$app->user->identity->user_level;
        $modules = RolePermission::find()
                             ->select('ML.module_name, ML.controller, ML.icon')
                             ->join('LEFT JOIN', 'modules_list AS ML', 'ML.module_id = role_module_permission.module_id')
                             ->where('role_id = :role_id', [':role_id' => $role_id])
                             ->andWhere('role_module_permission.view = :view', [':view' => 1])
                             ->andWhere('is_active = :is_active', [':is_active' => 1])
                             ->asArray()->all();
            
        $items = array();
        $items[] = '<li class="header">Menu</li>';
        $items[] = '<li id="dashboard"><a href="'. Url::to(['/']).'"><span class="fa fa-dashboard"></span> Dashboard</a></li>';
        for($i=0; $i<count($modules); $i++)
        {
            $items[] = '<li id="'.$modules[$i]['controller'].'"><a href="'. Url::to([$modules[$i]['controller'].'/']).'"><span class="fa '.$modules[$i]['icon'].'"></span> '.$modules[$i]['module_name'].'</a></li>';
        }
        return $items;
    }
    
    public function getPermission() {
        $actions = [];
        $actions['index']  = 'view';
        $actions['view']   = 'view';
        $actions['create'] = 'new';
        $actions['update'] = 'save';
        $actions['delete'] = 'remove';
        $actions['signup'] = 'save';
        $actions['permission'] = 'view';
        $actions['about'] = 'view';
        
        $role_id = Yii::$app->user->identity->user_level;    	
        $action = $actions[Yii::$app->controller->action->id];
        $controller = Yii::$app->controller->id;
        
        $permission = RolePermission::find()
                             ->select($action)
                             ->join('LEFT JOIN', 'modules_list AS ML', 'ML.module_id = role_module_permission.module_id')
                             ->where('role_id = :role_id', [':role_id' => $role_id])
                             ->andWhere($action.' = :'.$action, [':'.$action => 1])
                             ->andWhere('controller = :controller', [':controller' => $controller])
                             ->one();
        
       // return $permission;
        return [
            'user_level'=>Yii::$app->user->identity->user_level,
            'controller->action->id'=>Yii::$app->controller->action->id,
            'controller->id'=>Yii::$app->controller->id
                ];
        return $permission[$action] ? true : false;
    }
}

?>
<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "role_module_permission".
 *
 * @property int $id
 * @property int $role_id
 * @property int $module_id
 * @property int $new CREATE
 * @property int $view READ
 * @property int $save UPDATE
 * @property int $remove DELETE
 * @property string $added_at
 * @property string $added_by
 *
 * @property ModulesList $module
 * @property RoleTypes $role
 */
class RolePermission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role_module_permission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'module_id', 'new', 'view', 'save', 'remove'], 'integer'],
            [['new', 'view', 'save', 'remove'], 'required'],
            [['added_at'], 'safe'],
            [['added_by'], 'string', 'max' => 45],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModulesList::className(), 'targetAttribute' => ['module_id' => 'module_id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoleTypes::className(), 'targetAttribute' => ['role_id' => 'role_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'module_id' => 'Module ID',
            'new' => 'New',
            'view' => 'View',
            'save' => 'Save',
            'remove' => 'Remove',
            'added_at' => 'Added At',
            'added_by' => 'Added By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(ModulesList::className(), ['module_id' => 'module_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(RoleTypes::className(), ['role_id' => 'role_id']);
    }
}

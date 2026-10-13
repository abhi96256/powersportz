<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_role".
 *
 * @property integer $id
 * @property integer $parent_id 
 * @property string $role_name
 * @property string $child_id
 * @property string $status
 */
class UserRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id','child_id'], 'required'], 
            [['parent_id','child_id'], 'safe'], 
            [['role_name', 'status'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'User Type'), 
            'child_id'=>Yii::t('app', 'Department'), 
            'role_name' => Yii::t('app', 'Designation'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
    public static function ControllerAction(){

        $controllers = array();

        $appControllerPath =  realpath(dirname(__FILE__).'/../controllers'); 
        
        if(is_dir($appControllerPath)){
            if ($dh = opendir($appControllerPath)) 
            {
                
                while (($filename = readdir($dh)) !== false) 
                {
                    $file = $filename;
                    //echo filetype($appControllerPath .'/'. $file);
                   if(filetype($appControllerPath .'/'. $file) == 'file'){

                        $fp = fopen($appControllerPath.'/'.$file, 'r');
                        $method = $buffer = '';
                        while(!feof($fp))
                        {
                            $buffer .= fread($fp, 512);
                            if (preg_match_all('/public function\s+(\w+)(.*)?/', $buffer, $match)) {
                                $method = $match[1];
                            }
                        }
                        fclose($fp);
                        if(!empty($method)){
                            $method = array_filter($method,function($arr){
                                return strpos($arr, 'action') === 0 && $arr !== 'actions';
                            });
                        }
                        if(basename($filename, ".php") != 'SiteController'){
                           $controllers[basename($filename, ".php")]['not_selected'] = $method;
                        }
                    
                   }
                    //echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
                }
                closedir($dh);
        
            }
      }
        return $controllers;
    }
    public function getHeadRole($role_id = false){
        return yii\helpers\ArrayHelper::map(UserRole::find()->where("parent_id = 0 && id != '".$role_id."'")->asArray()->all(),'id','role_name');
    }
    public function getAllRole($role_id = false){
        return yii\helpers\ArrayHelper::map(UserRole::find()->asArray()->all(),'id','role_name');
    }
}

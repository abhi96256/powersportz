<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "videolike".
 *
 * @property integer $ID
 * @property integer $VideoID
 * @property integer $MemberID
 * @property integer $UserID
 * @property string $Created
 * @property string $Type
 */
class Videolike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'videolike';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VideoID', 'MemberID', 'UserID'], 'integer'],
            [['Created'], 'safe'],
            [['Type'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'VideoID' => 'Video ID',
            'MemberID' => 'Member ID',
            'UserID' => 'User ID',
            'Created' => 'Created',
            'Type' => 'Type',
        ];
    }
}

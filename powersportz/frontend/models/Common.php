<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the common model class.
 */
class Common extends \yii\db\ActiveRecord
{
    
    /* 
     * this function will change the thumbnails of video
     */
    public function chnageThumbnails( $type, $defaultThumb, $videoID )
    {
        $length = count($type);
        $random = rand(0,$length-1);
        // Update Thumb
        if($length > 1 && $defaultThumb[0]['ThumbID'] == $type[$random]['image_id'] )
        {
            $random = rand(0,$length-1);
        }
        $thumbID = $type[$random]['image_id'];

        $UpdateThumb = Yii::$app->db->createCommand()
            ->update('defaultthumbnail', ['ThumbID' =>$thumbID ], ['VideoID' => $videoID])
            ->execute();
    }
    
    public function get_custom_ads($CategID)
    {
        $procedure = 'SELECT * FROM `customadtopics` WHERE  IsDelete = 0 AND TopicsID = :TopicsID Order by Rand() limit 1';
        $connection = Yii::$app->db;
        $command = $connection->createCommand($procedure);
        $command->bindParam(":TopicsID", $CategID);
        $result = $command->queryAll();
        return $result;
    }
}

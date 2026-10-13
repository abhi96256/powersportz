<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Images;
use yii\data\SpDataProvider;

/**
 * ImagesSearch represents the model behind the search form about `backend\models\Images`.
 */
class ImagesSearch extends Images
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ImageID', 'VideoID', 'IsThumb', 'CreatedBy'], 'integer'],
            [['Title', 'ImageName', 'ImageType', 'Created'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        $arrParams = array();
        $arrParams['v_ImageTitle'] = $this->Title;
        $spDataProvider = new SpDataProvider([
			'spName' => 'Admin_Thumbnail_List',
			'params'=>$arrParams,
			'sort'=> [
				'attributes'=>[
					'ImageID'=>[
						'asc'=>['ImageID' => SORT_ASC],
						'desc'=>['ImageID' =>SORT_DESC],
						'default'=>SORT_ASC,
						'label'=>'ImageID'
					],
				],
				'defaultOrder'=>[
					'ImageID' => SORT_DESC
				]
			],  
			 //'sort' => $sort,
			'pagination' => [
				  'pageSize' => 10,
			],	 
		]);
        return $spDataProvider;
    }
}

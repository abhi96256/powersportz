<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Customadvertisement;
use yii\data\SpDataProvider;

/**
 * CustomadvertisementSearch represents the model behind the search form about `backend\models\Customadvertisement`.
 */
class CustomadvertisementSearch extends Customadvertisement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CustomAdvertiseID', 'IsAll', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['Title', 'URL', 'LandingLink', 'FromDate', 'ToDate', 'Status', 'Created', 'Updated','CustomAdvertiseID'], 'safe'],
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
        $arrParams['v_Title'] = $this->Title;
        $arrParams['v_URL'] = $this->URL;
        $arrParams['v_Status'] = $this->Status;
        $spDataProvider = new SpDataProvider([
			'spName' => 'Admin_Custom_Advertisement_List',
			'params'=>$arrParams,
			'sort'=> [
				'attributes'=>[
                    'CustomAdvertiseID'=>[
                      'asc'=>['CustomAdvertiseID' => SORT_ASC],
                      'desc'=>['CustomAdvertiseID' =>SORT_DESC],
                      'default'=>SORT_ASC,
                      'label'=>'ID'
                  ],
                  'Status'=>[
                      'asc'=>['Status' => SORT_ASC],
                      'desc'=>['Status' =>SORT_DESC],
                      'default'=>SORT_ASC,
                      'label'=>'Status'
                  ],
                  'Updated'=>[
                    'asc'=>['Updated' => SORT_ASC],
                    'desc'=>['Updated' =>SORT_DESC],
                    'default'=>SORT_ASC,
                    'label'=>'Status'
                ],
            ],
            'defaultOrder'=>[
             'Updated' => SORT_DESC
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

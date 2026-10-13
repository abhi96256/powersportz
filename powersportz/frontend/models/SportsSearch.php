<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Sports;
use yii\data\SpDataProvider;

/**
 * SportsSearch represents the model behind the search form about `frontend\models\Sports`.
 */
class SportsSearch extends Sports
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'ParentCategID', 'DisplayIndex', 'LangID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['CategName', 'CategThumb', 'Status', 'Created', 'Updated', 'Type'], 'safe'],
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
                                $arrParams['v_CategID'] ='';
                                $arrParams['v_CategoryType'] = '2';
                                $arrParams['v_Status'] ='1';    
                                $spDataProvider = new SpDataProvider([
                                    'spName' => 'Category_Get_List',
                                    //'totalCount'=>5,
                                    'params'=>$arrParams,
                                    'sort'=> [
                                           'attributes'=>[
                                                   'ID'=>[
                                                           'asc'=>['ID' => SORT_ASC],
                                                           'desc'=>['ID' =>SORT_DESC],
                                                           'default'=>SORT_ASC,
                                                           'label'=>'ID'
                                                   ],
                                           ],
                                           'defaultOrder'=>[
                                                   'ID' => SORT_ASC
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

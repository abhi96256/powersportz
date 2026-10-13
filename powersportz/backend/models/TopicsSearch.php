<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Topics;
use yii\data\SpDataProvider;

/**
 * TopicsSearch represents the model behind the search form about `backend\models\Topics`.
 */
class TopicsSearch extends Topics
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'ParentCategID', 'DisplayIndex', 'LangID', 'CreatedBy', 'UpdatedBy', 'Type'], 'integer'],
            [['CategName', 'CategThumb', 'Status', 'Created', 'Updated'], 'safe'],
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
       /*-- $query = Category::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'ParentCategID' => $this->ParentCategID,
            'DisplayIndex' => $this->DisplayIndex,
            'LangID' => $this->LangID,
            'CreatedBy' => $this->CreatedBy,
            'UpdatedBy' => $this->UpdatedBy,
            'Created' => $this->Created,
            'Updated' => $this->Updated,
        ]);

        $query->andFilterWhere(['like', 'CategName', $this->CategName])
            ->andFilterWhere(['like', 'Status', $this->Status]);

        return $dataProvider; --*/
		        $arrParams = array();
        $arrParams['v_CategoryName'] = $this->CategName;
        $arrParams['v_CategoryType'] = '2';
        $arrParams['v_Status'] = $this->Status;    
        $spDataProvider = new SpDataProvider([
			'spName' => 'Admin_category_list',
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
					'ID' => SORT_DESC
				]
			 ],  
			 //'sort' => $sort,
			'pagination' => [
				  'pageSize' => 10,
			 ],
			 
		]);
        return $spDataProvider;
    }
     /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return SPDataProvider
     */
    public function searchvideo()
    {
        $arrParams = array();
        $arrParams['v_CategoryId'] = $this->ID;
        $spDataProvider = new SpDataProvider([
			'spName' => 'Admin_Video_list',
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

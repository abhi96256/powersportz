<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Playlist;
use yii\data\SpDataProvider;

/**
 * PlaylistSearch represents the model behind the search form about `backend\models\Playlist`.
 */
class PlaylistSearch extends Playlist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'NoOfVideos', 'DisplayIndex', 'LangID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['Title', 'Description', 'VideoThumb', 'VideoURL', 'ScheduledRelease', 'Status', 'Created', 'Updated'], 'safe'],
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
         /*--  $query = Playlist::find();

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
            'NoOfVideos' => $this->NoOfVideos,
            'DisplayIndex' => $this->DisplayIndex,
            'ScheduledRelease' => $this->ScheduledRelease,
            'LangID' => $this->LangID,
            'CreatedBy' => $this->CreatedBy,
            'UpdatedBy' => $this->UpdatedBy,
            'Created' => $this->Created,
            'Updated' => $this->Updated,
        ]);

        $query->andFilterWhere(['like', 'Title', $this->Title])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'VideoThumb', $this->VideoThumb])
            ->andFilterWhere(['like', 'VideoURL', $this->VideoURL])
            ->andFilterWhere(['like', 'Status', $this->Status]);

        return $dataProvider;--*/
        		        $arrParams = array();
        $arrParams['v_PlaylistName'] = $this->Title;
        $arrParams['v_Status'] = $this->Status;    
        $spDataProvider = new SpDataProvider([
			'spName' => 'Admin_Playlist_Getlist',
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
}

<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Homepage;

/**
 * HomepageSearch represents the model behind the search form about `backend\models\Homepage`.
 */
class HomepageSearch extends Homepage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['HomeID'], 'integer'],
            [['MainVideoType', 'VideoID', 'ExternalVideoURL', 'AccompanyingID', 'NewsOrAdd', 'AdvertisementID', 'CategoryID'], 'safe'],
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
    public function search($params)
    {
        $query = Homepage::find();

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
            'HomeID' => $this->HomeID,
        ]);

        $query->andFilterWhere(['like', 'MainVideoType', $this->MainVideoType])
            ->andFilterWhere(['like', 'VideoID', $this->VideoID])
            ->andFilterWhere(['like', 'ExternalVideoURL', $this->ExternalVideoURL])
            ->andFilterWhere(['like', 'AccompanyingID', $this->AccompanyingID])
            ->andFilterWhere(['like', 'NewsOrAdd', $this->NewsOrAdd])
            ->andFilterWhere(['like', 'AdvertisementID', $this->AdvertisementID])
            ->andFilterWhere(['like', 'CategoryID', $this->CategoryID]);

        return $dataProvider;
    }
}

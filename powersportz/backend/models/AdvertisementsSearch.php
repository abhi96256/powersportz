<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Advertisements;

/**
 * AdvertisementsSearch represents the model behind the search form about `backend\models\Advertisements`.
 */
class AdvertisementsSearch extends Advertisements
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'ScrollTime', 'Status', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['ImagePath', 'Content', 'LandingLink', 'FromDate', 'ToDate', 'Created', 'Updated'], 'safe'],
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
        $query = Advertisements::find();

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
            'ScrollTime' => $this->ScrollTime,
            'FromDate' => $this->FromDate,
            'ToDate' => $this->ToDate,
            'Status' => $this->Status,
            'CreatedBy' => $this->CreatedBy,
            'UpdatedBy' => $this->UpdatedBy,
            'Created' => $this->Created,
            'Updated' => $this->Updated,
        ]);

        $query->andFilterWhere(['like', 'ImagePath', $this->ImagePath])
            ->andFilterWhere(['like', 'Content', $this->Content])
            ->andFilterWhere(['like', 'LandingLink', $this->LandingLink]);

        return $dataProvider;
    }
}

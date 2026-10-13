<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Breakingnews;

/**
 * BreakingnewsSearch represents the model behind the search form about `backend\models\Breakingnews`.
 */
class BreakingnewsSearch extends Breakingnews
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'LangID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['Title', 'ReleaseScheduled', 'ExpiryDateTime', 'Status', 'Created', 'Updated','LandingLink'], 'safe'],
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
        $query = Breakingnews::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['Status'=>SORT_ASC,'Updated'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'LandingLink' => $this->LandingLink,
            'ReleaseScheduled' => $this->ReleaseScheduled,
            'ExpiryDateTime' => $this->ExpiryDateTime,
            'LangID' => $this->LangID,
            'CreatedBy' => $this->CreatedBy,
            'UpdatedBy' => $this->UpdatedBy,
            'Created' => $this->Created,
            'Updated' => $this->Updated,
        ]);

        $query->andFilterWhere(['like', 'Title', $this->Title])
            ->andFilterWhere(['like', 'Status', $this->Status]);

        return $dataProvider;
    }
}

<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Gamerule;

/**
 * GameruleSearch represents the model behind the search form about `backend\models\Gamerule`.
 */
class GameruleSearch extends Gamerule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'DisplayIndex', 'LangID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['GameName', 'Title', 'Description', 'Thumb', 'ReleaseDate', 'Status', 'Created', 'Updated'], 'safe'],
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
        $query = Gamerule::find();

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
            'DisplayIndex' => $this->DisplayIndex,
            'ReleaseDate' => $this->ReleaseDate,
            'LangID' => $this->LangID,
            'CreatedBy' => $this->CreatedBy,
            'UpdatedBy' => $this->UpdatedBy,
            'Created' => $this->Created,
            'Updated' => $this->Updated,
        ]);

        $query->andFilterWhere(['like', 'GameName', $this->GameName])
            ->andFilterWhere(['like', 'Title', $this->Title])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'Thumb', $this->Thumb])
            ->andFilterWhere(['like', 'Status', $this->Status]);

        return $dataProvider;
    }
}

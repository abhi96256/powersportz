<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Playlists;

/**
 * PlaylistsSearch represents the model behind the search form about `frontend\models\Playlists`.
 */
class PlaylistsSearch extends Playlists
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
    public function search($params)
    {
        $query = Playlists::find();

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

        return $dataProvider;
    }
}

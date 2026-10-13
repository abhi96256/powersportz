<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Member;

/**
 * MemberSearch represents the model behind the search form about `frontend\models\Member`.
 */
class MemberSearch extends Member
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MemberID', 'Occupation', 'Interest', 'UserID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['FirstName', 'LastName', 'DOB', 'Email', 'MobileNo', 'Designation', 'Gender', 'DeviceType', 'DeviceToken', 'SignupType', 'Status', 'ActivationCode', 'ActivatedOn', 'Created', 'Updated'], 'safe'],
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
        $query = Member::find();

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
            'MemberID' => $this->MemberID,
            'DOB' => $this->DOB,
            'Occupation' => $this->Occupation,
            'Interest' => $this->Interest,
            'UserID' => $this->UserID,
            'ActivatedOn' => $this->ActivatedOn,
            'Created' => $this->Created,
            'Updated' => $this->Updated,
            'CreatedBy' => $this->CreatedBy,
            'UpdatedBy' => $this->UpdatedBy,
        ]);

        $query->andFilterWhere(['like', 'FirstName', $this->FirstName])
            ->andFilterWhere(['like', 'LastName', $this->LastName])
            ->andFilterWhere(['like', 'Email', $this->Email])
            ->andFilterWhere(['like', 'MobileNo', $this->MobileNo])
            ->andFilterWhere(['like', 'Designation', $this->Designation])
            ->andFilterWhere(['like', 'Gender', $this->Gender])
            ->andFilterWhere(['like', 'DeviceType', $this->DeviceType])
            ->andFilterWhere(['like', 'DeviceToken', $this->DeviceToken])
            ->andFilterWhere(['like', 'SignupType', $this->SignupType])
            ->andFilterWhere(['like', 'Status', $this->Status])
            ->andFilterWhere(['like', 'ActivationCode', $this->ActivationCode]);

        return $dataProvider;
    }
}

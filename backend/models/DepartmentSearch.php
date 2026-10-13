<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserRole;

/**
 * UserRoleSearch represents the model behind the search form about `backend\models\UserRole`.
 */
class DepartmentSearch extends Department
{
     public function search($params)
    {
        $query = UserRole::find()->where(['parent_id'=>2,'child_id'=>0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
            'defaultOrder' => ['id'=>SORT_DESC],
        ],
        ]);
       
        
      
        $this->load($params);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id'=>$this->parent_id,
        ]);
      
        $query->andFilterWhere(['like', 'role_name', $this->role_name])
            ->andFilterWhere(['like', 'status', $this->status]);
        
          
        return $dataProvider;
    }
}
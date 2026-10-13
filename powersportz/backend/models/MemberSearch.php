<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Member;
use yii\data\SpDataProvider;

/**
 * MemberSearch represents the model behind the search form about `backend\models\Member`.
 */
class MemberSearch extends Member
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MemberID', 'UserID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['FirstName', 'LastName','Designation',  'Email', 'Password', 'MobileNo', 'DOB', 'Gender', 'DeviceType', 'DeviceToken', 'SignupType', 'Status', 'ActivationCode', 'ActivatedOn', 'Created', 'Updated'], 'safe'],
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
      /*  $query = Member::find();

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
            ->andFilterWhere(['like', 'Password', $this->Password])
            ->andFilterWhere(['like', 'MobileNo', $this->MobileNo])
            ->andFilterWhere(['like', 'Gender', $this->Gender])
            ->andFilterWhere(['like', 'DeviceType', $this->DeviceType])
            ->andFilterWhere(['like', 'DeviceToken', $this->DeviceToken])
            ->andFilterWhere(['like', 'SignupType', $this->SignupType])
            ->andFilterWhere(['like', 'Status', $this->Status])
            ->andFilterWhere(['like', 'ActivationCode', $this->ActivationCode]);

        return $dataProvider;*/
        
              
       /* $fromJoinDate = '';
        $toJoinDate = '';
        if(isset($_POST['Member']['FromJoinDate']) && $_POST['Member']['FromJoinDate']!='') {
            $fromJoinDate = date("Y-m-d",strtotime($_POST['Member']['FromJoinDate']));
        }
        if(isset($_POST['Member']['ToJoinDate']) && $_POST['Member']['ToJoinDate']!='') {
            $toJoinDate = date("Y-m-d",strtotime($_POST['Member']['ToJoinDate']));
        }*/
        $arrParams = array();
        //$arrParams['v_FromJoinDate'] = $fromJoinDate;
        //$arrParams['v_ToJoinDate'] = $toJoinDate;
        $arrParams['v_MemberName'] = $this->FirstName;
        $arrParams['v_Gender'] = $this->Gender;
        $arrParams['v_SignupType'] = $this->SignupType;
        $arrParams['v_Status'] = $this->Status;
        $arrParams['v_Designation'] = $this->Designation;
       // echo "<pre>";print_r($arrParams);die;
         
        $spDataProvider = new SpDataProvider([
			'spName' => 'Admin_Suscribers_GetList',
			//'totalCount'=>5,
			 'params'=>$arrParams,
			 'sort'=> [
				'attributes'=>[
					'MemberID'=>[
						'asc'=>['MemberID' => SORT_ASC],
						'desc'=>['MemberID' =>SORT_DESC],
						'default'=>SORT_DESC,
						'label'=>'MemberID'
					],
				],
				'defaultOrder'=>[
					'MemberID' => SORT_DESC
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

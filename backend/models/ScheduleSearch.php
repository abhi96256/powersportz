<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Schedule;
use yii\data\SpDataProvider;

/**
 * ScheduleSearch represents the model behind the search form about `backend\models\Schedule`.
 */
class ScheduleSearch extends Schedule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ScheduleID', 'VideoID'], 'integer'],
            [['ProgramTitle', 'ScheduleDate','ScheduleFromTime', 'ScheduleTime', 'Status'], 'safe'],
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
        $query = Schedule::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'Updated' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        } 

        
        if (!empty($this->ScheduleFromTime) && empty($this->ScheduleTime)) { 
            $query->andWhere(['>=', 'ScheduleFromTime', ConvertDateToUTC($this->ScheduleFromTime,'Y-m-d H:i:s')]);
        } elseif (empty($this->ScheduleFromTime) && !empty($this->ScheduleTime)) {
           $query->andWhere(['<=', 'ScheduleTime', ConvertDateToUTC($this->ScheduleTime,'Y-m-d H:i:s')]);
       } elseif (!empty($this->ScheduleFromTime) && !empty($this->ScheduleTime)) {
        $query->andWhere(['>=', 'ScheduleFromTime', ConvertDateToUTC($this->ScheduleFromTime,'Y-m-d H:i:s')]);
        $query->andWhere(['<=', 'ScheduleTime', ConvertDateToUTC($this->ScheduleTime,'Y-m-d H:i:s')]);
    }


    $query->andFilterWhere([
        'ScheduleDate' => $this->ScheduleDate,
        'ScheduleTime' => $this->ScheduleTime,
    ]);

    $query->andFilterWhere(['like', 'ProgramTitle', $this->ProgramTitle]);


    return $dataProvider;
} 

     /* public function search()
    {
       // echo "hello"; die;
        $arrParams = array();
       if($this->ScheduleDate !='' ){
            $scheduledate= date('Y-m-d',  strtotime($this->ScheduleDate));
            $predate = $scheduledate.' '.'00:00:00';
            $pastdate = $scheduledate.' '.'23:59:59';
             
            $preutcdate = ConvertDateToUTC(date("Y-m-d H:i:s", strtotime($predate)));
            $pastutcdate = ConvertDateToUTC(date("Y-m-d H:i:s", strtotime($pastdate)));
             
             $arrParams['v_ScheduleDate'] = date('Y-m-d',  strtotime($this->ScheduleDate));
             $arrParams['v_PreScheduleDate'] = $preutcdate;
             $arrParams['v_PastScheduleDate'] = $pastutcdate;
           
           }else{
             //$arrParams['v_ScheduleDate'] = date('Y-m-d');
            $arrParams['v_ScheduleDate'] = '';
            $scheduledate= date('Y-m-d');
            $predate = $scheduledate.' '.'00:00:00';
            $pastdate = $scheduledate.' '.'23:59:59';
             
            $preutcdate = ConvertDateToUTC(date("Y-m-d H:i:s", strtotime($predate)));
            $pastutcdate = ConvertDateToUTC(date("Y-m-d H:i:s", strtotime($pastdate)));
             
            
             $arrParams['v_PreScheduleDate'] = $preutcdate;
             $arrParams['v_PastScheduleDate'] = $pastutcdate;
           }
       
        //echo   $arrParams['v_ScheduleDate'];die;
           //echo "<pre>";print_r($arrParams);die;
       
         
        $spDataProvider = new SpDataProvider([
			'spName' => 'Admin_Schedule_List',
			//'totalCount'=>5,
			 'params'=>$arrParams,
			 'sort'=> [
				'attributes'=>[
					'ScheduleID'=>[
						'asc'=>['ScheduleID' => SORT_ASC],
						'desc'=>['ScheduleID' =>SORT_DESC],
						'default'=>SORT_ASC,
						'label'=>'ScheduleID'
					],
                    'Created'=>[
                        'asc'=>['Created' => SORT_ASC],
                        'desc'=>['Created' =>SORT_DESC],
                        'default'=>SORT_ASC,
                        'label'=>'Created'
                    ],
                    'Updated'=>[
                        'asc'=>['Updated' => SORT_ASC],
                        'desc'=>['Updated' =>SORT_DESC],
                        'default'=>SORT_ASC,
                        'label'=>'Updated'
                    ],
				],
				'defaultOrder'=>[
                    'Created' => SORT_DESC,
                    'Updated'=>SORT_DESC,
				
				]
			 ],  
			 //'sort' => $sort,
			'pagination' => [
				  'pageSize' => 10,
			 ],
			 
		]);

        return $spDataProvider;
    }*/
}

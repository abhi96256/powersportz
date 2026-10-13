<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Video;
use yii\data\SpDataProvider;
/**
 * videoSearch represents the model behind the search form about `backend\models\Video`.
 */
class VideoSearch extends Video
{
    public $username;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GeneratedThumbnailTime','ChangeThumbnailTime','MetaKeywords','AdvertisementTagRL','DisplayIndex','PublishDate','Title','Description', 'AllowDownload', 'Status'], 'required','on'=>'create'],
            [['GeneratedThumbnailTime','ChangeThumbnailTime','MetaKeywords','AdvertisementTagRL','DisplayIndex','PublishDate','Title','Description', 'AllowDownload', 'Status'], 'required','on'=>'update'],
            ['Topics','TopicsValidate'],
            ['Category','CategoryValidate'],
            ['Playlist','PlaylistValidate'],
            ['CountryRestrictions','CountryRestrictionsValidate'],
            [['AdvertisementTagRL'],'url', 'defaultScheme' => 'http'],
            [['Title', 'Status','PublishDate','CategoryName','username'], 'safe'],
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
        $arrParams = array();
        $arrParams['v_VideoTitle'] = $this->Title;
        $arrParams['v_Category'] = $this->Category;
        $arrParams['v_Status'] = $this->Status;
        $arrParams['v_Key'] = AESKEY;
        $arrParams['v_ApproverName'] = $this->username;
        $spDataProvider = new SpDataProvider([
         'spName' => 'Admin_Video_List',
         'params'=>$arrParams,
         'sort'=> [
            'attributes'=>[
               'ID'=>[
                  'asc'=>['ID' => SORT_ASC],
                  'desc'=>['ID' =>SORT_DESC],
                  'default'=>SORT_ASC,
                  'label'=>'ID'
              ],
              'Status'=>[
                  'asc'=>['Status' => SORT_ASC],
                  'desc'=>['Status' =>SORT_DESC],
                  'default'=>SORT_ASC,
                  'label'=>'Status'
              ],       
              'slug'=>[
                  'asc'=>['slug' => SORT_ASC],
                  'desc'=>['slug' =>SORT_DESC],
                  'default'=>SORT_ASC,
                  'label'=>'Title'
              ],
              'Updated'=>[
                'asc'=>['v.Updated' => SORT_ASC],
                'desc'=>['v.Updated' =>SORT_DESC],
                'default'=>SORT_DESC,
                'label'=>'Updated'
            ],
        ],
        'defaultOrder'=>[
           'Updated' => SORT_DESC
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

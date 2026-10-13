<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert; 
?>

<?php 
$links=[]; 
  // echo '<pre>';print_r(Yii::$app->request->getQueryParams());
  // echo '<pre>';print_r(Yii::$app->request->get());exit;

if(Yii::$app->controller->id == 'video'){
    if(Yii::$app->request->get('CategoryID')){
        $CategoryID = Yii::$app->request->get('CategoryID');
        $category = (new \yii\db\Query())
        ->select(['ID', 'CategName','slug','Type'])
        ->from('category')
        ->where(['ID'=> $CategoryID ])
        ->orWhere(['slug'=> $CategoryID ])
        ->one();
        
        if($category['Type']==2){
           $links[] = [
            'label'=>'Action',
            'url' => ['action/'],
        ]; 
        $links[] = [
            'label'=>$category['CategName'],
            'url' => ['action/'.Yii::$app->request->get('CategoryID')],
        ]; 
    }else if($category['Type']==3){
      $links[] = [
        'label'=>'Talking Turkey',
        'url' => ['talking-turkey/'],
    ]; 
    $links[] = [
        'label'=>$category['CategName'],
        'url' => ['talking-turkey/',['id'=>Yii::$app->request->get('CategoryID')]],
    ]; 
} 

} 

}else if(Yii::$app->controller->id == 'sports'){ 
    if(Yii::$app->request->get('id')){
      $links[] = [
        'label'=>'Action',
        'url' => ['action/'],
    ]; 
}
}else if(Yii::$app->controller->id =='playlistdetails'){ 

    $links[] = [
        'label'=>'Throwback',
        'url' => ['throwback/'],
    ];

    if(Yii::$app->request->get('id') && Yii::$app->request->get('video')){
        $playlists = (new \yii\db\Query())
        ->select(['ID', 'Title','slug'])
        ->from('playlist')
        ->where(['ID'=> Yii::$app->request->get('id') ])
        ->orWhere(['slug'=>Yii::$app->request->get('id')])
        ->one();
        $links[] = [
            'label'=> $playlists['Title'],
            'url' => ['throwback/'.Yii::$app->request->get('id')]

        ];
    }
}else if(Yii::$app->controller->id =='talking-points' && Yii::$app->getRequest()->getQueryParam('id')){ 

    $links[] = [
        'label'=>'Talking Turkey',
        'url' => ['talking-turkey/'],
    ];
}
$links[] = [
    'label'=>$this->title
];
$controller = Yii::$app->controller;
$default_controller = Yii::$app->defaultRoute;
$isHome = (($controller->id === $default_controller) && ($controller->action->id === $controller->defaultAction)) ? true : false;
if(!$isHome){ ?>
<?php  
    $class= in_array($controller->id,['sports','topics','talking-points','member'])?'two-section':'one-section';
    if($controller->id == 'playlists'){
        $class="playlist-section";
    }

?>
<div class="col-md-11">
    <div class="col-md-12 breadcrumbs-content <?= $class ?>">
        <?php 
        echo Breadcrumbs::widget([
        'itemTemplate' => "<li>{link}</li>\n", // template for all links
        'links' => $links
        ]); ?>  
    </div>
</div>
<?php
}
?>
<?php

use yii\helpers\Html;

$contentForAccompanying = '';
$addvideobuttonForAccompanying = '';
if (!empty($amVideo)) {
    foreach ($amVideo as $videolistsub) {
        $videothumb = $videolistsub['ImageName'];
        if ($videothumb != '') {
            $videothumbpage =
                    '<img class="thumbnail img-responsive" src="' . ImagesUrl($videolistsub). '">';
        } else {
            $videothumbpage =
                    Html::img('@web/images/thumbnail-default.jpg',
                            ['class' => 'thumbnail img-responsive']);
        }
        $contentForAccompanying.='<div class="col-lg-3 col-sm-4 col-xs-6 ">' . $videothumbpage . '<p>' . $videolistsub['Title'] . '</p><input type="hidden" class="orderingVideoId" name="change_order" value='.$videolistsub['ID'] .'></div>';
    }
    $addvideobuttonForAccompanying = Html::label('Reorder Accompnying Videos','',['onClick'=>'ChangeOrderForAccompnyvideo();','class' => 'btn btn-primary','style' => 'cursor:pointer']);
} else {
    $contentForAccompanying = 'Image advertisement not showing';
}

?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="alert alert-danger addvdoslcterrshw" style="display:none">Please Select Video</div>
                <div class="displaycontetnForAccompanying"><div class="row" id="sortable"><?php echo $contentForAccompanying; ?></div></div>
            </div>
            <div class="panel-footer"><?= $addvideobuttonForAccompanying;?></div>
        </div>
    </div>
</div>
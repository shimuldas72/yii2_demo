<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'first_name',
            'last_name',
            'username',
            'email:email',
            [
                'attribute'=>'status',
                'value'=> ucfirst($model->status)
            ],
            [
                'label' => 'Gallery Type',
                'value' => $model->gallery->type
            ],
            [
                'label' => 'Images',
                'format'=>'raw',
                'value' => function($model){
                    $html = '';
                    $images = $model->gallery->images;
                    if(count($images) > 0){
                        foreach ($images as $img) {
                            $html .= '<img src="'.Url::base().'/images/user/'.$img->image.'" width="50" >&nbsp;';
                        }
                    }
                    return $html;
                }
            ],
            'created_by',
            'updated_by',
            [
                'attribute'=>'created_at',
                'value'=> date_format(date_create($model->created_at), 'F j Y h:i a')
            ],
            [
                'attribute'=>'updated_at',
                'value'=> date_format(date_create($model->updated_at), 'F j Y h:i a')
            ],
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?php
                if($model->isNewRecord){
            ?>
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
            <?php
                }
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive', 'deleted' => 'Deleted', '' => '', ], ['prompt' => 'Select status']) ?>
        </div>
    </div>

    <hr/>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($gallery, 'type')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


    <?php
        $count = 0;
        if(isset($images) && count($images) > 0){
            foreach ($images as $key => $value) {
                $count++;
                //$image_model->image = $value->image;
    ?>

                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($image_model, 'image['.$value->id.']')->fileInput()->label('Image '.$count) ?>
                        </div>
                        <div class="col-md-4">
                            <img src="<?= $url = Url::base().'/images/user/'.$value->image; ?>" width="50">
                        </div>
                    </div>

    <?php
            }
        }else{
    ?>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($image_model, 'image[0]')->fileInput()->label('Image 1') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($image_model, 'image[1]')->fileInput()->label('Image 2') ?>
                </div>
            </div>

    <?php
        }
    ?>
    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

namespace app\controllers;

use Yii;

use app\models\User;
use app\models\UserSearch;
use app\models\Gallery;
use app\models\Images;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile; 
use yii\helpers\Url;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $gallery = new Gallery();
        $image_model = new Images();
        $image_model->scenario = 'upload_validate';

        if ($model->load(Yii::$app->request->post()) && $gallery->load(Yii::$app->request->post())) {
            $image_model->image = UploadedFile::getInstances($image_model, 'image');

            $valid = $model->validate();
            $valid = $gallery->validate() && $valid;
            $valid = $image_model->validate() && $valid;


            if($valid){

                $model->password = Yii::$app->security->generatePasswordHash($model->password);
                $model->save();

                $gallery->user_id = $model->id;
                $gallery->save();

                if(!file_exists(\Yii::getAlias('@webroot').'/images/user/')){
                    mkdir(\Yii::getAlias('@webroot').'/images/user/',0777,true);
                }

                $path = \Yii::getAlias('@webroot').'/images/user/';

                if(count($image_model->image) > 0){
                    foreach ($image_model->image as $key => $value) {
                        $img_model = new Images();
                        $img_model->scenario = 'create_update';
                        $img_model->name = $value->baseName;
                        $img_model->ext = $value->extension;
                        $img_model->image = time().rand(100,999).'.'.$value->extension;
                        $img_model->gallery_id = $gallery->id;
                        if($img_model->save()){
                            $value->saveAs($path.$img_model->image);
                        }
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                //exit('ok');
            }
            
        }

        return $this->render('create', [
            'model' => $model,
            'gallery' => $gallery,
            'image_model' => $image_model
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $gallery = $model->gallery;
        if(empty($gallery)){
            $gallery = new Gallery();
        }
        $images = $gallery->images;

        $image_model = new Images();
        $image_model->scenario = 'update_validate';

        if ($model->load(Yii::$app->request->post()) && $gallery->load(Yii::$app->request->post())) {
            $gallery->user_id = $model->id;

            $image_model->image = UploadedFile::getInstances($image_model, 'image');
            

            $valid = $model->validate();
            $valid = $gallery->validate() && $valid;
            $valid = $image_model->validate() && $valid;


            if($valid){
                $model->save();
                $gallery->save();

                if(count($images) > 0){
                    if(!file_exists(\Yii::getAlias('@webroot').'/images/user/')){
                        mkdir(\Yii::getAlias('@webroot').'/images/user/',0777,true);
                    }

                    $path = \Yii::getAlias('@webroot').'/images/user/';

                    foreach ($images as $key => $img_model) {
                        $image = UploadedFile::getInstances($image_model, 'image['.$img_model->id.']');

                        if(count($image) > 0){
                            $image = $image[0];

                            $old_image = $img_model->image;

                            $img_model->scenario = 'create_update';
                            $img_model->name = $image->baseName;
                            $img_model->ext = $image->extension;
                            $img_model->image = time().rand(100,999).'.'.$image->extension;
                            if($img_model->save()){

                                if(file_exists(\Yii::getAlias('@webroot').'/images/user/'.$old_image)){
                                    unlink(\Yii::getAlias('@webroot').'/images/user/'.$old_image);
                                }

                                $image->saveAs($path.$img_model->image);
                            }
                        }
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }

        return $this->render('update', [
            'model' => $model,
            'gallery' => $gallery,
            'image_model' => $image_model,
            'images' => $images
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $gallery = $model->gallery;
        if(!empty($gallery)){
            $images = $gallery->images;
            foreach ($images as $img) {
                if(file_exists(\Yii::getAlias('@webroot').'/images/user/'.$img->image)){
                    unlink(\Yii::getAlias('@webroot').'/images/user/'.$img->image);
                }

                $img->delete();
            }

            $gallery->delete();
        }
        
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

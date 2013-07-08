<?php

class ItemsController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/frontend';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
 * Specifies the access control rules.
 * This method is used by the 'accessControl' filter.
 * @return array access control rules
 */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'images', 'view', 'create', 'vote'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update', 'admin', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $modal = false;
        if (isset($_GET['modal'])) {
            $modal = true;
            $this->layout = '//layouts/modal';
        }

        $comment = new Comments('create');
        $comment->item_id = $id;
        $comment->is_admin = (int)!Yii::app()->user->isGuest;

        $params = array('item_id' => $id, 'ip' => Yii::app()->request->userHostAddress);
        $hasVoted = (int)Votes::model()->count('item_id = :item_id AND ip = :ip', $params);

        //$this->performAjaxValidation($model);

        if (isset($_POST['Comments'])) {
            $comment->attributes = $_POST['Comments'];
            if ($comment->save()) {
                Yii::app()->user->setFlash('success', "Ваша комментарий отправлен!");
                $this->redirect(array('/items/view/id/' . $id));
            }
        }

        $this->render('view', array(
            'model' => $this->loadModel($id)->with('comments'),
            'modal' => $modal,
            'commentModel' => $comment,
            'hasVoted' => $hasVoted
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Items('create');

        //$this->performAjaxValidation($model);

        if (isset($_POST['Items'])) {
            $model->attributes = $_POST['Items'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Ваша цитата отправлена!");
                $this->redirect(array('/' . $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Items'])) {
            $model->attributes = $_POST['Items'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Prepare list of models with sorting
     * @return mixed
     */
    private function getItemsList()
    {
        $model = Items::model()->published();
        $sortType = isset($_GET['sort_type']) ? $_GET['sort_type'] : null;
        $sortDirection = isset($_GET['sort_dir']) ? $_GET['sort_dir'] : null;
        $model->sortBy($sortType, $sortDirection);

        return $model;
    }

    /**
     * Lists all quotes.
     */
    public function actionIndex()
    {
        $model = $this->getItemsList()->quotes();
        $dataProvider = new CActiveDataProvider($model);
        $this->render('list', array(
            'dataProvider' => $dataProvider,
            'itemTemplate' => '_quote'
        ));
    }

    /**
     * Lists all images.
     */
    public function actionImages()
    {
        $model = $this->getItemsList()->images();
        $dataProvider = new CActiveDataProvider($model);
        $this->render('list', array(
            'dataProvider' => $dataProvider,
            'itemTemplate' => '_image'
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Items('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Items']))
            $model->attributes = $_GET['Items'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionVote($id)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect('/items');
        }

        $ip = Yii::app()->request->userHostAddress;
        $params = array(
            'item_id' => $id,
            'ip' => $ip,
        );

        $votes = (int)Votes::model()->count('item_id = :item_id AND ip = :ip', $params);

        if ($votes > 0) {
            $msg = "Ошибка: вы уже голосовали за данный контент";
            $error = true;
        } else {
            $votes = new Votes();
            $votes->attributes = $params;
            if ($votes->save()) {
                $msg = "Ваш голос учтен!";
                $error = false;
            } else {
                $msg = "Произошла ошибка, повторите свой запрос позднее";
                $error = true;
            }
        }

        $response = json_encode(array(
            'msg' => $msg,
            'error' => $error,
        ));

        echo $response;

        Yii::app()->end();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Items the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Items::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Items $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'items-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

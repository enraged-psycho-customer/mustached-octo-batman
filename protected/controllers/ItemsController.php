<?php

class ItemsController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/frontend';

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xF2F2F2,
                'foreColor' => 0xED1B23,
                'transparent' => true,
                'testLimit' => 1,
                'height' => 50,
            ),
            'coco' => array(
                'class' => 'CocoAction',
            ),
        );
    }

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
                'actions' => array('index', 'images', 'view', 'get', 'save', 'create', 'vote', 'captcha', 'coco'),
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

    // Get comments for image
    public function actionGet($id)
    {
        $annotations = array();
        $comments = Comments::model()->findAllByAttributes(array('item_id' => $id));

        foreach ($comments as $comment) {
            if (!is_null($comment->x) && !is_null($comment->y)) {
                $annotation = array(
                    'left' => $comment->x,
                    'top' => $comment->y,
                    'width' => 48,
                    'height' => 48,
                    'text' => $comment->content,
                    'id' => $comment->id,
                    'editable' => false,
                );

                $annotations[] = (object)$annotation;
            }
        }

        echo json_encode($annotations);
        exit;
    }

    // Save comments for image
    public function actionSave($id)
    {
        $comment = new Comments('create_hover');
        $comment->content = $_GET['text'];
        $comment->item_id = $id;
        $comment->x = $_GET['left'];
        $comment->y = $_GET['top'];
        $comment->save();

        echo json_encode((object)array('id' => $comment->id));
        exit;
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $modal = false;
        $fancy = false;
        if (isset($_GET['modal'])) $modal = true;
        if (isset($_GET['fancy'])) $fancy = true;

        $comment = new Comments('create');
        $comment->item_id = $id;
        $comment->is_admin = (int)!Yii::app()->user->isGuest;

        $params = array('item_id' => $id, 'ip' => Yii::app()->request->userHostAddress);
        $hasVoted = (int)Votes::model()->count('item_id = :item_id AND ip = :ip', $params);

        //$this->performAjaxValidation($model);

        if (isset($_POST['Comments'])) {
            $comment->attributes = $_POST['Comments'];
            if ($comment->save()) {
                Yii::app()->user->setFlash('success', "Ваш комментарий отправлен!");
            } else {
                $errors = $comment->getErrors();
                foreach ($errors as $attribute => $attributeErrors) {
                    foreach ($attributeErrors as $error) {
                        Yii::app()->user->setFlash('error', $error);
                    }
                }
            }

            $this->redirect('/' . $id);
        }

        $model = $this->loadModel($id);
        $template = 'view';
        switch ($model->category) {
            case Items::CATEGORY_QUOTES:
                $template = 'view';
                break;

            case Items::CATEGORY_IMAGES:
                $template = 'image';
                break;
        }

        if ($fancy) {
            $template = 'fancy';
            $this->layout = 'empty';
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            Yii::app()->clientScript->registerScriptFile($this->assetsUrl . '/js/jquery-1.7.1.js');
            Yii::app()->clientScript->registerScriptFile($this->assetsUrl . '/js/jquery-ui-1.8.17.js');
            Yii::app()->clientScript->registerScriptFile($this->assetsUrl . '/js/jquery.annotate.js');
        }

        $params = array(
            'model' => $model->with('comments'),
            'modal' => $modal,
            'commentModel' => $comment,
            'hasVoted' => $hasVoted
        );

        if ($modal) {
            Yii::app()->clientScript->scriptMap['*.js'] = false;
            $this->renderPartial($template, $params, false, true);
        } else {
            $this->render($template, $params);
        }

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
                Yii::app()->user->setFlash('success', "Ваша информация успешно сохранена!");
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
            'itemTemplate' => '_quote',
            'class' => 'comments',
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
            'itemTemplate' => '_image',
            'class' => 'images'
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

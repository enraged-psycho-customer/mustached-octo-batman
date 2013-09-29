<?php

class ItemsController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/frontend';

    public $defaultAction = 'quotes';

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
                'actions' => array('quotes', 'notes', 'fame', 'images', 'inquisition', 'view', 'create', 'vote', 'captcha', 'coco'),
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

    // Notes for images action
    public function actionNotes($id)
    {
        require_once "notes.class.php";
        $notesPath = implode(DIRECTORY_SEPARATOR, array(Yii::app()->basePath, "data", "notes")) . DIRECTORY_SEPARATOR;

        if (isset($_POST['image']) && !empty($_POST['image']))
            $oNote = new note($notesPath, $id);

        if (isset($_POST['position']) && !empty($_POST['position']))
            $position = $_POST['position'];

        if (isset($_POST['avatar']) && !empty($_POST['avatar']))
            $avatar = $_POST['avatar'];

        if (isset($_POST['note']) && !empty($_POST['note']))
            $note = (string) strip_tags($_POST['note']);

        if (isset($_POST['get']) && !empty($_POST['get']))
            echo json_encode($oNote->getNotes());

        if (isset($_POST['add']) && !empty($_POST['add']))
            echo json_encode($oNote->addNote($position, $note, $avatar));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->pageTitle = Yii::app()->name . ' - №' . $id;

        $modal = false;
        $fancy = false;
        if (isset($_GET['modal'])) $modal = true;
        if (isset($_GET['fancy'])) {
            $fancy = true;
        }

        // Comment handling
        $comment = new Comments('create');
        $comment->item_id = $id;
        $comment->is_admin = (int)!Yii::app()->user->isGuest;

        if (Yii::app()->request->isAjaxRequest && !isset($_GET['modal'])) {
            $messages = CActiveForm::validate($comment);

            if ($messages == '[]' && isset($_POST['Comments'])) {
                $comment->attributes = $_POST['Comments'];
                $comment->save(false);

                $item = Items::model()->findByPk($comment->item_id);
                $tplParams = array(
                    'index' => $comment->parent_id,
                    'comment' => $comment,
                    'model' => $item
                );

                $messages = json_encode(array(
                    'success' => true,
                    'item_id' => $comment->item_id,
                    'parent_id' => $comment->parent_id,
                    'commentHtml' => $this->renderPartial('application.views.items._comment', $tplParams, true)
                ));
            }

            echo $messages;
            Yii::app()->end();
        }

        // View type handling
        $model = $this->loadModel($id);
        $template = 'view/quote';
        switch ($model->category) {
            case Items::CATEGORY_QUOTES:
                $template = 'view/quote';
                break;

            case Items::CATEGORY_IMAGES:
                $this->image = $this->createAbsoluteUrl($model->getImageDir() . $model->image);
                $template = 'view/image';
                break;

            case Items::CATEGORY_INQUISITION:
                $template = 'view/inquisition';
                break;
        }

        // Global stuff for sharing
        $this->category = $model->category;
        $this->viewLink = $this->createAbsoluteUrl('/items/view', array('id' => $model->id));
        $this->description = $this->viewLink;
        if ($model->category != Items::CATEGORY_IMAGES) {
            $description = preg_replace('/\<br(\s*)?\/?\>/i', " ", $model->content);
            $this->description = strip_tags($description);
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
            'commentModel' => $comment
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
        $this->pageTitle = Yii::app()->name . ' - Отправить своё';
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
        $this->layout = '//layouts/column2';
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
        $searchQuery = isset($_GET['query']) ? $_GET['query'] : null;
        $model->filterBy($searchQuery, $sortType, $sortDirection);

        return $model;
    }

    /**
     * Lists all quotes.
     */
    public function actionQuotes()
    {
        $this->pageTitle = Yii::app()->name . ' - Цитаты';
        $model = $this->getItemsList()->quotes();
        $dataProvider = new CActiveDataProvider($model);

        $this->render('list', array(
            'dataProvider' => $dataProvider,
            'itemTemplate' => 'list/_quote',
            'class' => 'comments',
            'search' => false,
        ));
    }

    /**
     * Lists all images.
     */
    public function actionImages()
    {
        $this->pageTitle = Yii::app()->name . ' - Картинки';
        $model = $this->getItemsList()->images();
        $dataProvider = new CActiveDataProvider($model);

        $this->render('list', array(
            'dataProvider' => $dataProvider,
            'itemTemplate' => 'list/_image',
            'class' => 'images',
            'search' => false,
        ));
    }

    public function actionInquisition()
    {
        $this->pageTitle = Yii::app()->name . ' - Инкивизиция';
        $model = $this->getItemsList()->inquisition();
        $dataProvider = new CActiveDataProvider($model);

        $this->render('list', array(
            'dataProvider' => $dataProvider,
            'itemTemplate' => 'list/_inquisition',
            'class' => 'comments',
            'search' => true,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $this->layout = '//layouts/column2';
        $model = new Items('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Items']))
            $model->attributes = $_GET['Items'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionFame()
    {
        $this->render('fame', array(

        ));
    }

    public function actionVote($id)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect('/items');
        }

        $command = Yii::app()->db->createCommand();
        $command->attachBehavior('InsertUpdateCommandBehavior', new InsertUpdateCommandBehavior);
        $command->insertUpdate(Votes::model()->tableName(), array(
            'item_id' => $id,
            'ip' => Yii::app()->request->userHostAddress,
            'updated_at' => new CDbExpression('NOW()'),
        ), array(
            'item_id' => $id,
            'ip' => Yii::app()->request->userHostAddress,
            'updated_at' => new CDbExpression('NOW()'),
        ));

        $response = json_encode(array(
            'error' => false,
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
}

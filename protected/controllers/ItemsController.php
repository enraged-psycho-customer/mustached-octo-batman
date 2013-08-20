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
                'actions' => array('quotes', 'notes', 'fame', 'images', 'inquisition', 'view', 'get', 'save', 'create', 'vote', 'captcha', 'coco'),
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

    // Notes for images action
    public function actionNotes($id)
    {
        require_once "notes.class.php";
        $notesPath = implode(DIRECTORY_SEPARATOR, array(Yii::app()->basePath, "data", "notes")) . DIRECTORY_SEPARATOR;

        if (isset($_POST['image']) && !empty($_POST['image']))
            $oNote = new note($notesPath, $id);

        /*
        if (isset($_POST['id']) && !empty($_POST['id']))
            $id = (int) strip_tags($_POST['id']);
        */

        if (isset($_POST['position']) && !empty($_POST['position']))
            $position = $_POST['position'];

        if (isset($_POST['note']) && !empty($_POST['note']))
            $note = (string) strip_tags($_POST['note']);

        /*
        if (isset($_POST['link']) && !empty($_POST['link']))
            $link = (string) strip_tags($_POST['link']);

        if (isset($_POST['author']) && !empty($_POST['author']))
            $author = (string) strip_tags($_POST['author']);
        */

        if (isset($_POST['get']) && !empty($_POST['get']))
            echo json_encode($oNote->getNotes());

        if (isset($_POST['add']) && !empty($_POST['add']))
            echo json_encode($oNote->addNote($position, $note));

        /*
        if (isset($_POST['delete']) && !empty($_POST['delete']))
            echo json_encode($oNote->deleteNote($id));

        if (isset($_POST['edit']) && !empty($_POST['edit']))
            echo json_encode($oNote->editNote($id, $position, $note, $author, $link));
        */
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
        $template = 'view/quote';
        switch ($model->category) {
            case Items::CATEGORY_QUOTES:
                $template = 'view/quote';
                break;

            case Items::CATEGORY_IMAGES:
                $template = 'view/image';
                break;

            case Items::CATEGORY_INQUISITION:
                $template = 'view/inquisition';
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
        $this->pageTitle = Yii::app()->name . ' - Отрпавить своё';
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

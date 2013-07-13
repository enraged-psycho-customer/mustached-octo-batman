<?php

class ToolsController extends Controller
{
    const GRANULARITY = 100;

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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('counters', 'folders'),
                'users' => array('*'),
            ),
            /*
            array('deny', // deny all users
                'users' => array('*'),
            ),
            */
        );
    }

    public function actionFolders()
    {
        chmod(Items::IMAGE_DIR, 0777);
        chmod(Items::IMAGE_TEMP_DIR, 0777);
    }

    public function actionCounters()
    {
        Yii::app()->db->createCommand('UPDATE items SET comments_count = 0')->query();
        $itemsCount = (int)Items::model()->count();

        for ($i = 0; $i < $itemsCount; $i = $i + self::GRANULARITY) {
            $list = Items::model()->findAll(array(
                'with' => array('commentsCount'),
                'limit' => self::GRANULARITY,
                'offset' => $i
            ));

            foreach ($list as &$item) {
                if ($item->commentsCount > 0) {
                    Items::model()->updateByPk($item->id, array('comments_count' => $item->commentsCount));
                }
            }
        }


        $this->render('debug');

        //Yii::app()->end();
    }
}
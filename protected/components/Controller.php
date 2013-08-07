<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/frontend';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    // Shared resources
    public $assetsUrl = null;
    public $votes = array();

    /**
     * Initialization
     */
    public function init()
    {
        $this->initAssets();
        $this->pageTitle = Yii::app()->name;
    }

    public function beforeAction($event)
    {
        $this->isMaintenanceMode();
        return true;
    }

    public function isMaintenanceMode()
    {
        if (isset(Yii::app()->params['maintenanceMode'])) {
            if (Yii::app()->user->isGuest && !in_array($this->action->id, array('login', 'logout'))) {
                $this->layout = '//layouts/teaser';
                $this->render('application.views.site.teaser');
                Yii::app()->end();
            }
        }
    }

    public function initAssets()
    {
        // Publish theme assets
        if (is_dir(Yii::app()->theme->basePath . '/assets')) {
            $assetsDir = Yii::app()->theme->basePath . '/assets';
            $this->assetsUrl = Yii::app()->assetManager->publish($assetsDir, false, 2, YII_DEBUG);
        };
    }

    public function pageTitle($title)
    {
        $this->pageTitle = $this->pageTitle . " - " . $title;
    }
}
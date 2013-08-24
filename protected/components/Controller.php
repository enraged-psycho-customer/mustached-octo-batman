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
    public $stage = null;

    /**
     * Initialization
     */
    public function init()
    {
        $this->initAssets();
        $this->pageTitle = Yii::app()->name;
        $this->stage = Stages::init();
        $this->showAnnouncement();
    }

    public function showAnnouncement()
    {
        $currentAnnouncement = Yii::app()->params['currentAnnouncement'];
        $cookieName = 'announcement_' . $currentAnnouncement;

        if (isset(Yii::app()->request->cookies[$cookieName])) {
            $cookie = Yii::app()->request->cookies[$cookieName];
            if (isset($cookie->value) && (int)$cookie->value != 1) {
                Yii::app()->request->cookies[$cookieName] = new CHttpCookie($cookieName, 1, array(
                    'expire' => time() + 3600 * 24 * 7
                ));
                $this->redirect('/site/announcement');
            }
        }
    }

    public function beforeAction($event)
    {
        $this->isMaintenanceMode();
        $this->isValidStage();
        return true;
    }

    public function isValidStage()
    {
        if (Yii::app()->user->isGuest) {
            if (isset(Stages::$_pages[$this->action->id])) {
                $pageLevel = Stages::$_pages[$this->action->id];
                if ($this->stage < $pageLevel) {
                    throw new CHttpException(500, 'Страница еще не готова!');
                }
            }
        }
    }

    public function isMaintenanceMode()
    {
        if (isset(Yii::app()->params['maintenanceMode']) && Yii::app()->params['maintenanceMode'] == 1) {
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
            $this->assetsUrl = Yii::app()->assetManager->publish($assetsDir, false, 10, YII_DEBUG);
        };
    }

    public function pageTitle($title)
    {
        $this->pageTitle = $this->pageTitle . " - " . $title;
    }
}
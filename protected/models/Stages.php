<?php
/**
 * Launch stages
 */
class Stages
{
    private static $_stage = 0;

    const STAGE_INIT = 1;
    const STAGE_HALL_OF_FAME = 1;
    const STAGE_INQUISITION = 8;

    const STAGE_CONTEST = 3;
    const STAGE_BATTLES = 4;
    const STAGE_SHOP = 8;

    public static $_pages = array(
        'quotes' => self::STAGE_INIT,
        'images' => self::STAGE_INIT,
        'battles' => self::STAGE_BATTLES,
        'inquisition' => self::STAGE_INQUISITION,
        'shop' => self::STAGE_SHOP,
        'fame' => self::STAGE_HALL_OF_FAME,
    );

    /* Stages */
    public static $_stages = array(
        0 => 'boss',
        1 => 'client',
        2 => 'designer',
        3 => 'courier',
        4 => 'painter',
        5 => 'marketer',
        6 => 'guard',
        7 => 'secretary',
        8 => 'manager',
        9 => 'artdirector',
        10 => 'typographe',
        11 => 'granny'
    );

    /* Logos */
    public static $_logos = array(
        0 => 'boss',
        1 => 'client',
        2 => 'courier',
        3 => 'painter',
        4 => 'marketer',
        5 => 'guard',
        6 => 'secretary',
        7 => 'manager',
        8 => 'artdirector',
        9 => 'typographe',
        10 => 'granny'
    );

    public static $_categories = array(
        1 => 'Цитаты',
        2 => 'Картинки',
        3 => 'Инквизиция'
    );

    public static function getCategory($category)
    {
        if (isset(self::$_categories[$category])) {
            return self::$_categories[$category];
        }

        return null;
    }

    public static function init()
    {
        self::$_stage = Yii::app()->params['currentStage'];
        return self::$_stage;
    }

    public static function getRandomLogo($assetsUrl)
    {
        $limit = self::$_stage;
        if (self::$_stage > sizeof(self::$_logos)) $limit = sizeof(self::$_logos);

        $logo_id = rand(0, $limit - 1);
        return CHtml::image($assetsUrl . "/images/logos/logo_" . self::$_logos[$logo_id] . ".png", '', array('class' => 'logo'));
    }

    public static function getStage() {
        return self::$_stage;
    }
}
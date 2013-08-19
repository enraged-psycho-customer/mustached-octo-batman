<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="<?php echo Yii::app()->language; ?>"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <!-- Favicon -->
    <?php echo $this->renderPartial('application.views.partials.favicons'); ?>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/hellclients.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/sprites.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/responsive.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/fonts/stylesheet.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/flashes.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/override.css"/>

    <!-- JavaScript -->
    <script type="text/javascript" src="<?php echo $this->assetsUrl; ?>/js/common.js"></script>
    <script type="text/javascript" src="<?php echo $this->assetsUrl; ?>/js/jquery-ui-1.8.17.js"></script>
    <script type="text/javascript" src="<?php echo $this->assetsUrl; ?>/js/jquery.annotate.js"></script>

    <script type="text/javascript">
        var teletypeText = '#$%^@#$!';

        var settings = {
            avatarsCount: <?php echo Stages::getStage(); ?>
        };

        $(['<?php echo $this->assetsUrl; ?>/images/loader.png', '<?php echo $this->assetsUrl; ?>/images/loader_small.png']).preload();
    </script>
</head>

<body>

<div id="wrapper">
    <a id="contest_mobile" href="<?php echo $this->createUrl('/contest'); ?>" title="Конкурс">&nbsp;</a>

    <div id="sidebar">
        <div id="logo">
            <?php echo CHtml::link(Stages::getRandomLogo($this->assetsUrl), array('/quotes')); ?>
        </div>

        <div id="sidebar_inner">
            <div id="create" class="menu">
                <?php $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '
                        <a class="prev" href="javascript:void(0)"><i class="icon right icon-vig_left"></i></a>
                        {menu}
                        <a class="next" href="javascript:void(0)"><i class="icon left icon-vig_right"></i></a>
                    ',
                    'items' => array(
                        array('label' => 'Отправить своё', 'url' => array('/items/create')),
                    ),
                )); ?>
            </div>

            <div id="nav_mobile" class="menu">
                <?php echo $this->renderPartial('application.views.partials.navigation_mobile'); ?>
            </div>

            <div id="nav" class="menu">
                <?php echo $this->renderPartial('application.views.partials.navigation'); ?>
            </div>

            <div id="contest">
                <?php if ($this->stage >= 2): ?>
                    <?php echo CHtml::link(CHtml::image($this->assetsUrl . "/images/contest.png"), array('/contest')); ?>
                    <div class="menu"><ul><li><?php echo CHtml::link('Конкурс', array('/contest')); ?></li></ul></div>
                <?php endif; ?>
            </div>

            <div id="hall_of_fame" class="menu">
                <?php $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Зал славы',
                            'url' => array('/fame'),
                            'visible' => $this->stage >= 11
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div>

    <div id="container">
        <div class="age_inner">
            <i class="icon icon-age"></i>
        </div>
        <div id="content">
            <?php echo $content; ?>
        </div>
    </div>


    <div class="clear"></div>
</div>

<?php $this->widget('Flashes'); ?>
<div class="age_top">
    <i class="icon icon-age"></i>
</div>
<div id="companion"></div>
<div id="balloon">
    <div id="balloon_text"></div>
</div>

<?php echo $this->renderPartial('application.views.partials.metrika'); ?>

</body>
</html>

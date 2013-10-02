<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="<?php echo Yii::app()->language; ?>"/>
    <title>АДОВЫЕ КЛИЕНТЫ / <?php echo CHtml::encode($this->pageTitle); ?></title>

    <!-- Favicon -->
    <?php echo $this->renderPartial('application.views.partials.favicons'); ?>

    <!-- Sharing -->
    <?php echo $this->renderPartial('application.views.partials.sharing'); ?>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/hellclients.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/sprites.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/responsive.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/fonts/stylesheet.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/override.css"/>

    <!-- JavaScript -->
    <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?98"></script>
    <script type="text/javascript" src="<?php echo $this->assetsUrl; ?>/js/common.js"></script>
    <script type="text/javascript" src="<?php echo $this->assetsUrl; ?>/js/imagesloaded.js"></script>
    <script type="text/javascript" src="<?php echo $this->assetsUrl; ?>/js/jquery.ias.js"></script>

    <!-- Plugins -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/plugins/jquery-notes/style.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/plugins/jquery-notes/lteIE8.css"/>
    <script type="text/javascript" src="<?php echo $this->assetsUrl; ?>/plugins/jquery-notes/jquery-notes_1.0.8.js"></script>
    <script type="text/javascript" src="<?php echo $this->assetsUrl; ?>/plugins/jquery-notes/jquery-ui.js"></script>

    <script type="text/javascript">
        var teletypeText = '#$%^@#$!';

        var settings = {
            avatarsCount: <?php echo Stages::getStage(); ?>,
            glowsCount: <?php echo Stages::getStage(); ?>
        };

        $([
            '<?php echo $this->assetsUrl; ?>/images/loader.png',
            '<?php echo $this->assetsUrl; ?>/images/loader_small.png',
            '<?php echo $this->assetsUrl; ?>/images/bg_pattern.png',
        ]).preload();
    </script>
</head>

<body>

<div id="wrapper">
    <?php if ($this->stage >= Stages::STAGE_CONTEST): ?>
        <a id="contest_mobile" href="<?php echo $this->createUrl('/contest'); ?>" title="Конкурс">&nbsp;</a>
    <?php else: ?>
        <a id="contest_mobile" href="javascript:void(0)" title="Coming soon ;)">&nbsp;</a>
    <?php endif; ?>

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

            <?php if ($this->stage >= Stages::STAGE_CONTEST): ?>
            <div id="contest">
                <?php echo CHtml::link(CHtml::image($this->assetsUrl . "/images/contest.png"), array('/contest')); ?>
                <div class="menu"><ul><li><?php echo CHtml::link('Конкурс', array('/contest')); ?></li></ul></div>
            </div>
            <?php endif; ?>

            <div id="hall_of_fame" class="menu">
                <?php $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Зал славы',
                            'url' => array('/fame'),
                            'visible' => $this->stage >= Stages::STAGE_HALL_OF_FAME
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div>

    <div id="container">
        <div class="age age_inner">
            <i class="icon icon-age"></i>
        </div>
        <div id="content">
            <?php echo $content; ?>
        </div>
    </div>

    <div class="clear"></div>

    <!-- Announcements -->
    <?php if ($this->action->id != 'announcement' && $this->showAnnouncement == 1): ?>
        <a class="announcement iframe" href="<?php echo $this->createUrl('/site/announcement'); ?>">&nbsp;</a>
        <?php
        $this->widget('application.extensions.fancybox.EFancyBox', array(
            'target' => 'a.announcement',
            'config' => array(
                'width' => '99%',
                'height' => '99%'
            ),
        ));
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('a.announcement').fancybox({width: '99%', height: '99%'}).trigger('click');
            });
        </script>
    <?php endif; ?>
</div>

<div class="age age_top">
    <i class="icon icon-age"></i>
</div>
<div id="companion"></div>
<a href="<?php echo $this->createUrl('/site/announcement'); ?>">
    <div id="balloon">
        <div id="balloon_text"></div>
    </div>
</a>

<?php echo $this->renderPartial('application.views.partials.metrika'); ?>

</body>
</html>

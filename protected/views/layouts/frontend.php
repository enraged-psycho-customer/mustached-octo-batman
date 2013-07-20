<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="<?php echo Yii::app()->language; ?>"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/hellclients.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/responsive.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/fonts/stylesheet.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/sprites.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/flashes.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/override.css"/>

    <!-- JavaScript -->
    <script type="text/javascript" src="<?php echo $this->assetsUrl; ?>/js/common.js"></script>
    <script type="text/javascript" src="<?php echo $this->assetsUrl; ?>/js/jquery-ui-1.8.17.js"></script>
    <script type="text/javascript" src="<?php echo $this->assetsUrl; ?>/js/jquery.annotate.js"></script>

    <script type="text/javascript">
        var teletypeText = '#$%^@#$!';
    </script>
</head>

<body>

<div id="wrapper">
    <div id="sidebar">
        <div id="logo">
            <?php echo CHtml::link(CHtml::image($this->assetsUrl . "/images/logos/logo_" . rand(1, 11) . ".png", '', array('class' => 'logo')), array('/items')); ?>
        </div>

        <div id="sidebar_inner">
            <div id="create" class="menu">
                <?php $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '<i class="icon left icon-vig_left"></i>{menu}<i class="icon right icon-vig_right"></i>',
                    'items' => array(
                        array('label' => 'Отправить своё', 'url' => array('/items/create')),
                    ),
                )); ?>
            </div>

            <div id="nav" class="menu">
                <?php $this->widget('zii.widgets.CMenu', array(
                    'itemTemplate' => '<i class="icon left icon-horn_left"></i>{menu}<i class="icon right icon-horn_right"></i>',
                    'items' => array(
                        array(
                            'label' => 'Цитаты',
                            'url' => array('/quotes'),
                            'active' => $this->action->id == 'quotes'
                        ),
                        array(
                            'label' => 'Картинки',
                            'url' => array('/images'),
                            'active' => $this->action->id == 'images'
                        ),
                        array(
                            'label' => 'Сражения',
                            'url' => array('/battles'),
                            'active' => $this->action->id == 'battles'
                        ),
                        array(
                            'label' => 'Инкивизиция',
                            'url' => array('/inquisition'),
                            'active' => $this->action->id == 'inquisition'
                        ),
                        array(
                            'label' => 'Магазинчик',
                            'url' => array('/shop'),
                            'active' => $this->action->id == 'shop'
                        ),
                    ),
                )); ?>
            </div>

            <div id="contest">
                <?php echo CHtml::link(CHtml::image($this->assetsUrl . "/images/contest.png"), array('/contest')); ?>
            </div>

            <div id="hall_of_fame" class="menu">
                <?php $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array('label' => 'Зал славы', 'url' => array('/fame')),
                    ),
                )); ?>
            </div>
        </div>
    </div>

    <div id="container">
        <div id="content">
            <?php echo $content; ?>
        </div>
    </div>


    <div class="clear"></div>
</div>

<?php $this->widget('Flashes'); ?>
<div id="age">
    <i class="icon icon-age"></i>
</div>
<div id="companion"></div>
<div id="balloon">
    <div id="balloon_text"></div>
</div>

</body>
</html>

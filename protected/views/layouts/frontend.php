<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="<?php echo Yii::app()->language; ?>"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/hellclients.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/sprites.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/override.css"/>

    <!-- JavaScript -->
    <script type="text/javascript" src="<?php echo $this->assetsUrl; ?>/js/common.js"></script>
    <script type="text/javascript" src="<?php echo $this->assetsUrl; ?>/js/teletype.js"></script>

    <script type="text/javascript">
        var teletypeText = '#$%^@#$!';
    </script>
</head>

<body>

<div id="wrapper">
    <div id="sidebar">
        <div id="logo">
            <?php echo CHtml::link(CHtml::image($this->assetsUrl . "/images/logo.png"), array('/items')); ?>
        </div>

        <div id="create" class="menu">
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => 'Отправить своё', 'url' => array('/items/create')),
                ),
            )); ?>
        </div>

        <div id="nav" class="menu">
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => 'Цитаты', 'url' => array('/items/index')),
                    array('label' => 'Картинки', 'url' => array('/items/images')),
                ),
            )); ?>
        </div>

        <div id="contest">
            <?php echo CHtml::link(CHtml::image($this->assetsUrl . "/images/contest.png"), array('/contest')); ?>
        </div>

        <div id="hall_of_fame" class="menu">
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => 'Зал славы', 'url' => array('/items/fame')),
                ),
            )); ?>
        </div>
    </div>

    <div id="content">
        <?php echo $content; ?>
    </div>

    <div class="clear"></div>
</div>

<div id="age"></div>
<div id="companion"></div>
<div id="balloon">
    <div id="balloon_text"></div>
</div>

</body>
</html>

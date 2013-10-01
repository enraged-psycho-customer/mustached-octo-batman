<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name . ' - День рождения';
?>

<style>
    #sidebar, #contest_mobile, #companion, #balloon {
        display: none;
    }

    #wrapper, #container, #content {
        height: 100%;
    }

    #content {
        margin: 0 !important;
        padding: 0;
        width: 100%;
        text-align: center;
    }

    #wrapper, #container, #content {
        height: 100%;
    }

    #content {
        text-align: center;
        padding-bottom: 0px;
    }

    .announcement {
        position: relative;
        top: 10%;
    }

    .achievement {
        margin-top: 25px;
    }

    .social-special {
        position: absolute;
        top: 45%;
        right: 0;
    }
</style>


<div class="announcement">
    <div>
        <img class="designer" src="<?php echo $this->assetsUrl; ?>/images/announcement/designer.png">
    </div>
    <div class="achievement">
        <img class="achievement" src="<?php echo $this->assetsUrl; ?>/images/announcement/achievement_1.png" usemap="#achievement">
    </div>
    <?php $this->renderPartial('application.views.items._social', array(
        'class' => 'social social-special',
        'shareUrl' => $this->createAbsoluteUrl('/site/announcement'),
        'closeUrl' => $this->createUrl('/items/quotes')
    )); ?>

</div>
<map name="achievement">
    <area shape="rect" coords="274,69,329,84" href="<?php echo $this->createUrl('/items/quotes'); ?>" alt="Цитаты">
    <area shape="rect" coords="333,69,401,84" href="<?php echo $this->createUrl('/items/images'); ?>" alt="Картинки">
</map>

<script type="text/javascript">
    $(document).ready(function() {
        $('.social-special a.close').click(function(e) {
            window.location.href = $(this).attr('href');
        });
    })
</script>
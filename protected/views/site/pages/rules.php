<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name . ' - Правила';
?>
<style type="text/css">
    body {
       background: url(<?php echo $this->assetsUrl; ?>/images/bg_pattern.png);
    }

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

    .rules_block {
        position: relative;
        top: 10%;
    }
</style>

<div class="rules_block">
    <img class="rules" src="<?php echo $this->assetsUrl; ?>/images/rules_agreement.png" usemap="#rules">
    <map name="rules">
        <area shape="rect" coords="167,433,347,513" href="javascript:void(0)" onclick="parent.$.fancybox.close();" alt="">
    </map>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('.age i').removeClass('icon-age').addClass('icon-age-pattern');
    });
</script>
<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - Правила';
?>
<style type="text/css">
    body {
       background: url(<?php echo $this->assetsUrl; ?>/images/bg_pattern.png);
    }

    #content {
        background: url(<?php echo $this->assetsUrl; ?>/images/rules_agreement.png) no-repeat center center;
        text-align: center;
        min-width: 509px;
        min-height: 581px;
        padding-top: 64px;
    }

    #companion, #balloon {
        display: none;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('.age i').removeClass('icon-age').addClass('icon-age-pattern');

    });
</script>
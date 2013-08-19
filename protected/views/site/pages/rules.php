<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name . ' - Правила';
?>
<style type="text/css">
    body {
       background: url(<?php echo $this->assetsUrl; ?>/images/bg_pattern.png);
    }

    #wrapper {
        height: 100%;
        background: url(<?php echo $this->assetsUrl; ?>/images/rules_agreement.png) no-repeat 66% 50%;
    }

    @media screen and (max-width: 640px) {
        #wrapper {
            height: 100%;
            background: url(<?php echo $this->assetsUrl; ?>/images/rules_agreement.png) no-repeat 50% 85%;
        }
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
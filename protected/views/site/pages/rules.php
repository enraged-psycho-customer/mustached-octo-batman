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

    #rules {
        height:100%;
        width: 100%;
        margin: 0;
        padding: 0;
        border: 0;
    }

    #rules td {
        vertical-align: middle;
        text-align: center;

    }

    img.rules {
        width: 509px;
        height: 581px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('.age i').removeClass('icon-age').addClass('icon-age-pattern');

    });
</script>
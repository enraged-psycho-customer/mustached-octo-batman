<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name . ' - Зал славы';
?>
<style type="text/css">
    body {
        background: #ED1C24 /*url(<?php echo $this->assetsUrl; ?>/images/bg_pattern.png) */;
    }

    .age_inner {
        display: none;
    }

    #wrapper {
        text-align: center;
        vertical-align: middle;
    }

    #wrapper, #container, #content, #hands, #right, #wolf {
        height: 100%;
    }

    a#contest_mobile {
        display: none;
    }

    #content {
        background: url(<?php echo $this->assetsUrl; ?>/images/team.png) no-repeat center center;
        padding-bottom: 0;
    }

    #hands {
        background: url(<?php echo $this->assetsUrl; ?>/images/hands.png) no-repeat bottom left;
    }

    #right {
        background: url(<?php echo $this->assetsUrl; ?>/images/fame_right.png) no-repeat bottom right;
    }

    #wolf {
        width: 100%;
        background: url(<?php echo $this->assetsUrl; ?>/images/wolf.png) no-repeat top left;
        text-align: center;
    }

    #team {
        height:100%;
        width: 100%;
        margin: 0;
        padding: 0;
        border: 0;
    }

    #team td {
        vertical-align: middle;
        text-align: center;

    }

    #fame_social_wrapper {
        background: url(<?php echo $this->assetsUrl; ?>/images/fame_social.png) no-repeat center center;
        width: 100%;
        margin-top: 30px;
    }

    #fame_social {
        height: 69px;
        text-align: center;
        margin: 0 auto;
        padding-left: 40px;
    }

    #fame_social .platform {
        display: inline-block;
        margin: 0 5px;
        text-align: center;
        padding-top: 25px;
    }

    #fame_social .facebook {
        width: 101px;
    }

    #fame_social .vk {
        width: 125px;
    }

    #fame_social .twitter {
        width: 138px;
    }

    #vk_like {
        margin-left: 25px;
    }

    img.team {
        width: 565px;
        height: 518px;
    }

    @media screen and (max-width: 1000px) {
        #wolf, #right, #hands {
            background-image: none;
        }
    }

    #companion, #balloon {
        display: none;
    }
</style>

<div id="hands">
    <div id="right">
        <div id="wolf">
            <table id="team">
                <tr>
                    <td>
                        <img class="team" src="<?php echo $this->assetsUrl; ?>/images/pixel.png" usemap="#team">
                        <div id="fame_social_wrapper">
                            <div id="fame_social">
                                <?php echo $this->renderPartial('application.views.partials.widgets', array('url' => $this->createAbsoluteUrl('/fame'))); ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<map name="team">
    <area shape="rect" coords="393,83,565,297" href="http://artkadabra.ru" alt="ARTKADABRA">
    <area shape="rect" coords="110,30,375,134" href="http://doesnotcompute.ru" alt="Does Not Compute">
</map>
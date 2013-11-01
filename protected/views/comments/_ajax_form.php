<?php
/**
 * Created by PhpStorm.
 * User: Yatskanich Oleksandr
 * Date: 01.11.13
 * Time: 17:45
 * @var $model Comments
 * @var $this CommentsController
 * @var $form CActiveForm
 */
?>
<style type="text/css">
    #commentForm{
        position: absolute;
        top: <?php echo $model->x; ?>px;
        left: <?php echo $model->y; ?>px;
    }
    #commentForm .border{
        position: relative;
        top: 15px;
        width: 100%;
        height: 100%;
        border: 0px none;
        outline: 0px none;
        float: left;
    }
    #commentForm .text-box{
        background: url(/images/notes_left.png) no-repeat center left;
        padding-left: 9px;
        margin-left: 50px;
        position: absolute;
        left: 0;
        width: 237px;
        height: 80px;
        z-index: 9990;
    }
</style>
<div id="commentForm" class="note select ui-draggable">
    <div class="border">
        <a href="javascript:void(0)" class="glow_switch up">
            <i class="icon icon-arrow_small_top_white"></i>
        </a>
        <a class="glow_current" href="javascript:void(0)" title="Аватар">
            <i data-avatar="1" class="glow-small glow-small_1"></i>
        </a>
        <a href="javascript:void(0)" class="glow_switch down">
            <i class="icon icon-arrow_small_bottom_white"></i>
        </a>
    </div>
<!--    <div class="avatar">-->
<!--        --><?php //if (Yii::app()->user->isGuest): ?>
<!--            <a href="javascript:void(0)" class="avatar_switch up">-->
<!--                <i class="icon icon-form_arrow_up"></i>-->
<!--            </a>-->
<!--            <a href="javascript:void(0)" title="Аватар"><i class="avatar avatars avatar_1" data-avatar="1"></i></a>-->
<!--            <a href="javascript:void(0)" class="avatar_switch down">-->
<!--                <i class="icon icon-form_arrow_down"></i>-->
<!--            </a>-->
<!--        --><?php //else: ?>
<!--            <a class="admin" href="javascript:void(0)" title="Аватар"><i class="avatar avatars avatar_0" data-avatar="0"></i></a>-->
<!--        --><?php //endif; ?>
<!--    </div>-->
    <div class="text-box">
        <div class="text-box-inner">
            <div class="form">
                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'comments-form',
                    'enableAjaxValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                )); ?>

                <?php echo $form->hiddenField($model, 'avatar', array('class' => 'avatar_field')); ?>
                <?php echo $form->hiddenField($model, 'parent_id', array('class' => 'parent_id')); ?>

                <div class="controls">
                    <div class="textarea">
                        <img src="<?php echo $this->assetsUrl; ?>/images/comment_arrow.png"/>
                        <?php echo $form->textArea($model, 'content'); ?>
                    </div>

                    <div class="button">
                        <button type="button"><i class="icon icon-checkbox"></i></button>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

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
        display: none;
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
        padding-left: 9px;
        margin-left: 50px;
        position: absolute;
        left: 0;
        width: 237px;
        height: 80px;
        z-index: 9990;
    }
    #commentForm a.up {
        position: absolute;
        left: 0;
        top: 0;
    }
    #commentForm a.down {
        position: absolute;
        left: 0;
        top: 42px;
    }
    #commentForm a.glow_current {
        position: absolute;
        top: 22px;
    }
    #commentForm .controls {
        background: #F2F2F2;
        position: relative;
        border-radius: 2px;
        box-shadow: 3px 3px 10px rgba(0,0,0, 0.5);
        height: 90px;
    }
    #commentForm .com-arr {
        top: 50%;
        margin-top: -4px;
    }
    #commentForm .textarea {
        padding: 5px;
        margin-right: 25px;
    }
    #commentForm .textarea textarea {
        border: none;
        width: 100%;
        height: 80px;
        background: #F2F2F2;
        font-size: 14px;
        resize:none;
        outline: none;
    }
    #commentForm .buttons {
        position: absolute;
        right: 3px;
        top: 5px;
    }
    #commentForm .buttons a{
        display: block;
        position: relative;
    }
    #commentForm .buttons a.save-note{
        bottom: -17px;
        right: 2px;
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

                <?php echo $form->hiddenField($model, 'avatar', array('class' => 'avatar_field','value'=>1)); ?>
                <?php echo $form->hiddenField($model, 'item_id'); ?>
                <?php echo $form->hiddenField($model, 'parent_id', array('class' => 'parent_id')); ?>
                <?php echo $form->hiddenField($model, 'x',array('class'=>'x_field')); ?>
                <?php echo $form->hiddenField($model, 'y',array('class'=>'y_field')); ?>

                <div class="controls">
                    <div class="textarea">
                        <?php echo $form->textArea($model, 'content'); ?>
                    </div>

                    <div class="buttons">
                        <a href="javascript:void(0);" class="cancel-note" title="Отменить"><i class="icon icon-close"></i></a>
                        <a href="javascript:void(0);" class="save-note" title="Сохранить"><i class="icon icon-checkbox"></i></a>
                    </div>
                    <div class="com-arr"></div>
                    <div class="limit">140</div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

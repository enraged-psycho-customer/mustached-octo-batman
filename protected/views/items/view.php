<?php
/* @var $this ItemsController */
/* @var $model Items */
/* @var $form CActiveForm */
/* @var $commentModel Comments */

$this->breadcrumbs = array(
    'Items' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List Items', 'url' => array('index')),
    array('label' => 'Create Items', 'url' => array('create')),
    array('label' => 'Update Items', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Items', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Items', 'url' => array('admin')),
);
?>

<?php
$script = <<< EOD
    $("div.comment.real").live("click", function(e) {
        e.preventDefault();
        $('#commentsFormSecond').show();
        $('#commentsFormSecond').insertAfter(this);
        $('#commentsFormSecond input#parent_id').val($(this).attr('data-id'));
        return false;
    });
EOD;

Yii::app()->clientScript->registerScript('comments', $script, CClientScript::POS_END);
?>

<div class="item" id="item_<?php echo $model->id; ?>" data-id="<?php echo $model->id; ?>">
    <div class="container">
        <div class="number">
            <?php echo CHtml::link('№' . $model->id, array('view', 'id' => $model->id)); ?>
        </div>

        <div class="comments">
            <span>
                <span class="comments_count active"><?php echo $model->comments_count; ?></span>
                <i class="sprite sprite_comments_active"></i>
            </span>
        </div>

        <div class="quote">
            <?php echo $this->purify($model->content); ?>
        </div>

        <div class="clear"></div>

        <div class="comments_list" id="comments_<?php echo $model->id; ?>">
            <?php $this->renderPartial('_comments', array('comments' => $model->getComments(), 'index' => 0)); ?>

            <div id="commentsFormSecond" class="commentsForm">
                <div class="comment">
                    <div class="avatar">
                        <a href="javascript:void(0)">
                            <i class="sprite sprite_form_arrow_up"></i>
                        </a>
                        <i class="sprite sprite_avatar_boy"></i>
                        <a href="javascript:void(0)">
                            <i class="sprite sprite_form_arrow_down"></i>
                        </a>
                    </div>
                    <div class="text">
                        <?php $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'comment-form',
                            'enableAjaxValidation' => false,
                        )); ?>

                        <?php echo $form->hiddenField($commentModel, 'parent_id', array('id' => 'parent_id')); ?>
                        <?php echo $form->textArea($commentModel, 'content'); ?>
                        <span><button class="checkbox" type="submit"><i class="sprite sprite_checkbox"></i></button></span>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>


            <div class="commentsForm">
                <div class="comment">
                    <div class="avatar">
                        <a href="javascript:void(0)">
                            <i class="sprite sprite_form_arrow_up"></i>
                        </a>
                        <i class="sprite sprite_avatar_boy"></i>
                        <a href="javascript:void(0)">
                            <i class="sprite sprite_form_arrow_down"></i>
                        </a>
                    </div>
                    <div class="text">
                        <?php $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'comment-form',
                            'enableAjaxValidation' => false,
                        )); ?>

                        <?php echo $form->textArea($commentModel, 'content'); ?>
                        <span><button class="checkbox" type="submit"><i class="sprite sprite_checkbox"></i></button></span>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="clear"></div>
<!--
<div class="social">
    <a href="javascript:void(0)">
        <i class="sprite sprite_close"></i>
    </a>
    <a href="javascript:void(0)">
        <i class="sprite sprite_like"></i>
    </a>
    <a href="javascript:void(0)">
        <i class="sprite sprite_vk"></i>
    </a>
    <a href="javascript:void(0)">
        <i class="sprite sprite_twitter"></i>
    </a>
    <a href="javascript:void(0)">
        <i class="sprite sprite_facebook"></i>
    </a>
</div>
-->
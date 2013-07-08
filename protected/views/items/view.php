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

<div class="item" id="item_<?php echo $model->id; ?>" data-id="<?php echo $model->id; ?>">
    <?php if ($modal): ?>
        <?php $this->renderPartial('_social', array('model' => $model, 'hasVoted' => $hasVoted)); ?>
    <?php endif; ?>

    <div class="container">
        <div class="number">
            <?php echo CHtml::link('№' . $model->id, array('view', 'id' => $model->id)); ?>
        </div>

        <div class="comments">
            <a class="expanded" href="javascript:void(0)">
                <span>
                    <span class="comments_count active"><?php echo $model->comments_count; ?></span>
                    <i class="icon icon-comments_active"></i>
                </span>
            </a>
        </div>

        <div class="quote">
            <?php echo $model->content; ?>
        </div>

        <div class="clear"></div>

        <div class="comments_list" id="comments_<?php echo $model->id; ?>">
            <?php $this->renderPartial('_comments', array('comments' => $model->getComments(), 'index' => 0)); ?>
            <?php $this->renderPartial('_commentsForm', array('model' => $commentModel, 'class' => 'commentsForm commentsFormNested')); ?>
            <?php $this->renderPartial('_commentsForm', array('model' => $commentModel, 'class' => 'commentsForm')); ?>
        </div>
    </div>
</div>

<div class="clear"></div>
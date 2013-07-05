<?php
/* @var $this ItemsController */
/* @var $model Items */

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

        <div id="comments_<?php echo $model->id; ?>" class="comments_list">
            <?php foreach ($model->comments as $comment): ?>
                <div class="comment">
                    <div class="avatar">
                        <i class="sprite <?php echo $comment->getAvatarClass(); ?>"></i>
                    </div>
                    <div class="text">
                        <?php echo $this->purify($comment->content); ?>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>
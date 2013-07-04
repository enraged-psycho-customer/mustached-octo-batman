<?php
/* @var $this ItemsController */
/* @var $model Items */

$this->breadcrumbs=array(
	'Items'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Items', 'url'=>array('index')),
	array('label'=>'Create Items', 'url'=>array('create')),
	array('label'=>'Update Items', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Items', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Items', 'url'=>array('admin')),
);
?>

<div class="item">
    <div class="number">
        <?php echo CHtml::link('№' . $model->id, array('view', 'id' => $model->id)); ?>
    </div>

    <div class="comments">
        <a href="javascript:void(0)">
            <span class="comments_count active"><?php echo $model->commentsCount; ?></span>
            <i class="sprite sprite_comments_active"></i>
        </a>
    </div>

    <div class="quote">
        <?php echo nl2br($model->content); ?>
    </div>
</div>
<div class="clear"></div>
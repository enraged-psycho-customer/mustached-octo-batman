<?php
/* @var $this ItemsController */
/* @var $data Items */
?>

<div class="item closed" id="item_<?php echo $data->id; ?>" data-id="<?php echo $data->id; ?>">
    <div class="number">
        <div class="trash"></div>
        <?php echo CHtml::link('№' . $data->id, array('view', 'id' => $data->id), array('class' => 'expand')); ?>
        <div class="comments_right">
            <a class="expand" href="<?php echo $this->createUrl('/items/view/', array('id' => $data->id)); ?>">
                <div><i class="icon icon-image_icon"></i></div>
                <div><span class="comments_count"><?php echo $data->comments_count; ?></span></div>
            </a>
        </div>
    </div>
    <div class="container">
        <div class="comments comments_image">
            <a class="expand" href="<?php echo $this->createUrl('/items/view/', array('id' => $data->id)); ?>">
                <div>
                    <span class="comments_count"><?php echo $data->comments_count; ?></span>
                </div>
                <div>
                    <i class="icon icon-image_icon"></i>
                </div>
            </a>
        </div>

        <div class="quote">
            <?php $this->renderPartial('_content', array('model' => $data, 'list' => true)); ?>
        </div>
    </div>
    <div class="max"></div>
</div>
<div class="clear"></div>
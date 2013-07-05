<?php
/* @var $this ItemsController */
/* @var $data Items */
?>

<div class="item">
    <div class="number">
        <?php echo CHtml::link('№' . $data->id, array('view', 'id' => $data->id)); ?>
    </div>

    <div class="comments">
        <a href="<?php echo $this->createUrl('/items/view/', array('id' => $data->id)); ?>">
            <span class="comments_count"><?php echo $data->comments_count; ?></span>
            <i class="sprite sprite_comments"></i>
        </a>
    </div>

    <div class="quote">
        Future is now
    </div>
</div>
<div class="clear"></div>
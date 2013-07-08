<?php
/* @var $this ItemsController */
/* @var $data Items */
?>

<div class="item" id="item_<?php echo $data->id; ?>" data-id="<?php echo $data->id; ?>">
    <div class="container">
        <div class="number">
            <?php echo CHtml::link('№' . $data->id, array('view', 'id' => $data->id), array('class' => 'expand')); ?>
        </div>

        <div class="comments">
            <a class="expand" href="<?php echo $this->createUrl('/items/view/', array('id' => $data->id)); ?>">
                <div>
                    <span class="comments_count"><?php echo $data->comments_count; ?></span>
                </div>
                <div>
                    <i class="icon icon-comments"></i>
                </div>
            </a>
        </div>

        <div class="quote">
            <?php echo $data->content; ?>
        </div>
    </div>
</div>
<div class="clear"></div>
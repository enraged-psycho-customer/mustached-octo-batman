<?php if ($model->category == Items::CATEGORY_IMAGES && !is_null($comment->x)): ?>
<div style="float: right"">
    <?php $x = (48 / $comment->width) * $comment->x; ?>
    <?php $y = (48 / $comment->height) * $comment->y; ?>
    <div style="background:url(<?php echo $model->getImageDir() . $model->image; ?>) <?php echo $x; ?>px <?php echo $y; ?>px; width: 48px; height: 48px;"></div>
</div>
<?php endif; ?>
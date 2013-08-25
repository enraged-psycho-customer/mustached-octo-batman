<?php if ($model->category == Items::CATEGORY_IMAGES && !is_null($comment->x)): ?>
<div style="float: right">
    <div class="clip" data-left="<?php echo $comment->x; ?>" data-top="<?php echo $comment->y; ?>">
        <img src="<?php echo $model->getImageDir() . $model->image; ?>" style="position: relative; width: 735px; height: 413px; left: -396px; top: -309px" />
    </div>
</div>
<?php endif; ?>
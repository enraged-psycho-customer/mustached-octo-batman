<div class="comment comment_<?php echo $comment->id; ?> <?php if ($index == 0) echo 'real'; else echo 'level'; ?> <?php if ($comment->is_admin) echo 'admin'; ?>" data-id="<?php echo $comment->id; ?>">
    <div class="avatar">
        <i class="avatars avatar_<?php echo $comment->avatar; ?>"></i>
    </div>
    <div class="text">
        <?php echo $comment->content; ?>
        <?php $this->renderPartial('_clip', array('model' => $model, 'comment' => $comment)); ?>
    </div>
</div>
<?php
/* @var $comments array */
/* @var $comment Comments */
/* @var $model Items */
?>

<?php foreach ($comments[$index] as $comment): ?>
    <div class="comment <?php if ($index == 0) echo 'real'; else echo 'level'; ?> <?php if ($comment->is_admin) echo 'admin'; ?>" data-id="<?php echo $comment->id; ?>">
        <div class="avatar">
            <i class="avatars avatar_<?php echo $comment->avatar; ?>"></i>
        </div>
        <div class="text">
            <?php echo $comment->content; ?>
            <?php //$this->renderPartial('_clip', array('model' => $model, 'comment' => $comment)); ?>
        </div>
    </div>

    <?php if (isset($comments[$comment->id])) $this->renderPartial('_comments', array('comments' => $comments, 'index' => $comment->id, 'model' => $model)); ?>
<?php endforeach; ?>
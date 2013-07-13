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

            <?php if ($model->category == Items::CATEGORY_IMAGES): ?>
            <div style="float: right"">
                <div style="background:url(<?php echo $model->getImageDir() . $model->image; ?>) -<?php echo $comment->x; ?>px -<?php echo $comment->y; ?>px; width: 48px; height: 48px;"></div>
            </div>
        <?php endif; ?>
        </div>
    </div>

    <?php if (isset($comments[$comment->id])) $this->renderPartial('_comments', array('comments' => $comments, 'index' => $comment->id)); ?>
<?php endforeach; ?>
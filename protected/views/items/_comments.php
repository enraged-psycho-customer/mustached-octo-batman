<?php foreach ($comments[$index] as $comment): ?>
    <?php /* @var $comment Comments */ ?>
    <div class="comment <?php if ($index == 0) echo 'real'; else echo 'level'; ?> <?php if ($comment->is_admin) echo 'admin'; ?>" data-id="<?php echo $comment->id; ?>">
        <div class="avatar">
            <i class="icon icon-<?php echo $comment->getAvatarClass(); ?>"></i>
        </div>
        <div class="text">
            <?php echo $this->purify($comment->content); ?>
        </div>
    </div>

    <?php if (isset($comments[$comment->id])) $this->renderPartial('_comments', array('comments' => $comments, 'index' => $comment->id)); ?>
<?php endforeach; ?>
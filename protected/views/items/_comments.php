<?php
/* @var $comments array */
/* @var $comment Comments */
/* @var $model Items */
?>

<?php foreach ($comments[$index] as $comment): ?>
    <?php $this->renderPartial('_comment', array('index' => $index, 'comment' => $comment)); ?>
    <?php if (isset($comments[$comment->id])) $this->renderPartial('_comments', array('comments' => $comments, 'index' => $comment->id, 'model' => $model)); ?>
<?php endforeach; ?>
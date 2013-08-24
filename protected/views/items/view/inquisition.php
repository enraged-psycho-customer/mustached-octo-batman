<?php
/* @var $this ItemsController */
/* @var $model Items */
/* @var $form CActiveForm */
/* @var $commentModel Comments */
?>
<div class="item_container">
    <div class="item_container_bottom">
        <div class="item item_text <?php if ($modal) echo 'open'; ?>" id="item_<?php echo $model->id; ?>" data-id="<?php echo $model->id; ?>">
            <?php if ($modal): ?>
                <?php $this->renderPartial('_social', array('shareUrl' => $this->createAbsoluteUrl('/' . $model->id), 'class' => 'social')); ?>
            <?php endif; ?>

            <div class="number">
                <?php echo CHtml::link('№' . $model->id, array('view', 'id' => $model->id)); ?>+
                <div class="comments_right">
                    <a class="expanded" href="javascript:void(0)">
                        <div><i class="icon icon-comments_active"></i></div>
                        <div><span class="comments_count"><?php echo $model->comments_count; ?></span></div>
                    </a>
                </div>
            </div>
            <div class="container">
                <div class="comments">
                    <a class="expanded" href="javascript:void(0)">
                    <span>
                        <span class="comments_count active"><?php echo $model->comments_count; ?></span>
                        <i class="icon icon-comments_active"></i>
                    </span>
                    </a>
                </div>

                <div class="quote">
                    <?php $this->renderPartial('_content', array('model' => $model)); ?>
                    <?php if ($modal): ?>
                        <?php $this->renderPartial('_social', array('shareUrl' => $this->createAbsoluteUrl('/' . $model->id), 'class' => 'social-small')); ?>
                    <?php endif; ?>
                </div>

                <div class="clear"></div>

                <div class="comments_list" id="comments_<?php echo $model->id; ?>">
                    <?php $this->renderPartial('_comments', array('comments' => $model->getComments(), 'index' => 0, 'model' => $model)); ?>
                    <?php $this->renderPartial('_commentsForm', array('model' => $commentModel, 'class' => 'commentsForm commentsFormNested')); ?>
                    <?php $this->renderPartial('_commentsForm', array('model' => $commentModel, 'class' => 'commentsForm commentsFormBottom')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
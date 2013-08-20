<?php
/* @var $this ItemsController */
/* @var $model Items */
/* @var $form CActiveForm */
/* @var $commentModel Comments */
?>
<div class="item_container">
    <div class="item_container_bottom">
        <div class="item <?php if ($modal) echo 'open'; ?>" id="item_<?php echo $model->id; ?>" data-id="<?php echo $model->id; ?>">
            <?php if ($modal): ?>
                <?php $this->renderPartial('_social', array('model' => $model, 'class' => 'social')); ?>
            <?php endif; ?>

            <div class="number">
                <?php echo CHtml::link('№' . $model->id, array('view', 'id' => $model->id)); ?>
            </div>
            <div class="container">
                <div class="comments comments_image">
                    <a class="expanded" href="javascript:void(0)">
                    <span>
                        <span class="comments_count active"><?php echo $model->comments_count; ?></span>
                        <i class="icon icon-image_icon_active"></i>
                    </span>
                    </a>
                </div>

                <div class="quote">
                    <?php $this->renderPartial('_content', array('model' => $model, 'list' => false)); ?>
                    <?php if ($modal): ?>
                        <?php $this->renderPartial('_social', array('model' => $model, 'class' => 'social-small')); ?>
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

<script type="text/javascript">
    $(function() {
        $('.image_item_<?php echo $model->id; ?>').jQueryNotes({
            minWidth: 48,
            minHeight: 48,
            maxWidth: 48,
            maxHeight: 48,
            aspectRatio: true,
            allowAdd: true,
            allowHide: false,
            allowReload: true,
            allowLink: false,
            allowAuthor: false,
            dateFormat: 'Y/D/M H:I',
            hideNotes: false,
            loadNotes: true,
            helper: '',
            maxNotes: null,
            operator: '<?php echo $this->createAbsoluteUrl('items/notes') ?>'
        });
    });

    $(window).resize(function() {
        $('.image_item_<?php echo $model->id; ?> a.reload-notes').trigger('click');
    });
</script>
<?php
/* @var $this ItemsController */
/* @var $model Items */
/* @var $form CActiveForm */
/* @var $commentModel Comments */

$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target' => 'a.fancybox',
    'config' => array(
        'width' => '85%',
        'height' => '85%'
    )
));
?>
<div class="item_container">
    <div class="item_container_bottom">
        <div class="item open" id="item_<?php echo $model->id; ?>" data-id="<?php echo $model->id; ?>">
            <?php if ($modal): ?>
                <?php $this->renderPartial('_social', array('model' => $model, 'hasVoted' => $hasVoted)); ?>
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
                    <?php $this->renderPartial('_content', array('model' => $model)); ?>
                </div>

                <div class="clear"></div>

                <div class="comments_list" id="comments_<?php echo $model->id; ?>">
                    <?php $this->renderPartial('_comments', array('comments' => $model->getComments(), 'index' => 0, 'model' => $model)); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!$modal): ?>
<script type="text/javascript">
    $(document).ready(function() {
        $("a.fancybox").fancybox({width: '85%', height: '85%'}).trigger('click');
    });
</script>
<?php endif; ?>
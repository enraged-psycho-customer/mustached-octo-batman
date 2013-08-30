<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'itemsForm',
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
)); ?>

<?php echo CHtml::hiddenField('sort_type', '', array('id' => 'sort_type')); ?>
<?php echo CHtml::hiddenField('sort_dir', '', array('id' => 'sort_dir')); ?>

<div id="shades">
    <div class="shade active">
        <div class="inner">
            <a class="sortBy updated_at desc" data-type="updated_at" data-dir="desc" href="<?php echo Yii::app()->createUrl($this->route, array('sort_type' => 'updated_at', 'sort_dir' => 'desc')); ?>">
                <i class="icon icon-<?php echo $class; ?>_time" title="Сортировать по новым комментариям"></i>
            </a>
            <a class="sortBy comments_count desc" data-type="comments_count" data-dir="desc" href="<?php echo Yii::app()->createUrl($this->route, array('sort_type' => 'comments_count', 'sort_dir' => 'desc')); ?>">
                <i class="icon icon-<?php echo $class; ?>_white" title="Сортировать по количеству комментариев"></i>
            </a>
            <a class="active sortBy created_at desc" data-type="created_at" data-dir="desc" href="<?php echo Yii::app()->createUrl($this->route, array('sort_type' => 'created_at', 'sort_dir' => 'desc')); ?>">
                <i class="icon icon-time_white" title="Сортировать по времени"></i>
            </a>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<div class="clear"></div>
<br/>

<?php if (isset($_GET['sort_type']) && isset($_GET['sort_dir'])): ?>
<script type="text/javascript">
    sortLinksSwitch($('a.sortBy.<?php echo $_GET['sort_type']; ?>.<?php echo $_GET['sort_dir']; ?>'));
</script>
<?php endif; ?>
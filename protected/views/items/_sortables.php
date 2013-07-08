<?php
$script = <<< EOD
    $("a.sortBy").live("click", function(e) {
        e.preventDefault();
        $('#itemsForm #sort_type').val($(this).attr('data-type'));
        $('#itemsForm #sort_dir').val($(this).attr('data-dir'));

        $('#shades .shade .inner a.sortBy').show();
        $(this).hide();

        $('#shades .shade').removeClass('active');
        $(this).parent().parent().addClass('active');

        $('#shades .shade .inner').removeClass('active');
        $(this).parent().addClass('active');

        $('#itemsForm').submit();
        return false;
    });

    $('#itemsForm').submit(function(){
        $.fn.yiiListView.update('itemsList', {
            data: $(this).serialize()
        });
        return false;
    });
EOD;

Yii::app()->clientScript->registerScript('filters', $script, CClientScript::POS_END);
?>


<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'itemsForm',
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
)); ?>

<?php echo CHtml::hiddenField('sort_type', '', array('id' => 'sort_type')); ?>
<?php echo CHtml::hiddenField('sort_dir', '', array('id' => 'sort_dir')); ?>

<div id="shades">
    <div class="shade">
        <div class="inner">
            <a class="sortBy" data-type="published_at" data-dir="asc" href="<?php echo Yii::app()->createUrl($this->route, array('sort_type' => 'published_at', 'sort_dir' => 'asc')); ?>">
                <i class="icon icon-arrow_white_top" title="Сортировать по-возрастанию"></i>
            </a>
            <span>
                <i class="icon icon-time_white" title="Сортировать по времени"></i>
            </span>
            <a class="sortBy" data-type="published_at" data-dir="desc" href="<?php echo Yii::app()->createUrl($this->route, array('sort_type' => 'published_at', 'sort_dir' => 'desc')); ?>">
                <i class="icon icon-arrow_white_bottom" title="Сортировать по-убыванию"></i>
            </a>
        </div>
    </div>
    <div class="shade">
        <div class="inner">
            <a class="sortBy" data-type="comments_count" data-dir="asc" href="<?php echo Yii::app()->createUrl($this->route, array('sort_type' => 'comments_count', 'sort_dir' => 'asc')); ?>">
                <i class="icon icon-arrow_white_top" title="Сортировать по-возрастанию"></i>
            </a>
            <span>
                <i class="icon icon-comments_white" title="Сортировать по количеству комментариев"></i>
            </span>
            <a class="sortBy" data-type="comments_count" data-dir="desc" href="<?php echo Yii::app()->createUrl($this->route, array('sort_type' => 'comments_count', 'sort_dir' => 'desc')); ?>">
                <i class="icon icon-arrow_white_bottom" title="Сортировать по-убыванию"></i>
            </a>
        </div>
    </div>
    <div class="shade">
        <div class="inner">
            <a class="sortBy" data-type="updated_at" data-dir="asc" href="<?php echo Yii::app()->createUrl($this->route, array('sort_type' => 'updated_at', 'sort_dir' => 'asc')); ?>">
                <i class="icon icon-arrow_white_top" title="Сортировать по-возрастанию"></i>
            </a>
            <span>
                <i class="icon icon-comments_time" title="Сортировать новым комментариям"></i>
            </span>
            <a class="sortBy" data-type="updated_at" data-dir="desc" href="<?php echo Yii::app()->createUrl($this->route, array('sort_type' => 'updated_at', 'sort_dir' => 'desc')); ?>">
                <i class="icon icon-arrow_white_bottom" title="Сортировать по-убыванию"></i>
            </a>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<div class="clear"></div>


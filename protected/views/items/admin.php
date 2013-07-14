<?php
/* @var $this ItemsController */
/* @var $model Items */

$this->breadcrumbs = array(
    'Items' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Items', 'url' => array('index')),
    array('label' => 'Create Items', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#items-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Items</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'items-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'content',
        'category',
        'state',
        'image',
        'created_at',
        'updated_at',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>

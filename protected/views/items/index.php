<?php
/* @var $this ItemsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Items',
);

$this->menu = array(
    array('label' => 'Create Items', 'url' => array('create')),
    array('label' => 'Manage Items', 'url' => array('admin')),
);
?>

<?php $this->renderPartial('_filters'); ?>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_quote',
    'pager' => array(
        'class' => 'CLinkPager',
        'maxButtonCount' => 7,
    ),
    'template' => '{items}{pager}'
)); ?>

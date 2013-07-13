<?php
/* @var $this ItemsController */
/* @var $dataProvider CActiveDataProvider */

$this->renderPartial('_sortables', array('class' => $class));

$this->widget('zii.widgets.CListView', array(
    'id' => 'itemsList',
    'dataProvider' => $dataProvider,
    'itemView' => $itemTemplate,
    'template' => '{items}{pager}',
    'pager' => array(
        'class' => 'CLinkPager',
        'maxButtonCount' => 5,
    ),
));

$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target' => 'a.fancybox',
    'config' => array(
        'width' => '85%',
        'height' => '85%'
    )
));
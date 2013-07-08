<?php
/* @var $this ItemsController */
/* @var $dataProvider CActiveDataProvider */

$this->renderPartial('_sortables');

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
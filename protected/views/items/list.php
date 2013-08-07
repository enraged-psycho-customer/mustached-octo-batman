<?php
/* @var $this ItemsController */
/* @var $dataProvider CActiveDataProvider */

$this->renderPartial('filters/_sort', array('class' => $class));

if ($search) $this->renderPartial('filters/_search');

$this->widget('zii.widgets.CListView', array(
    'id' => 'itemsList',
    'dataProvider' => $dataProvider,
    'itemView' => $itemTemplate,
    'template' => '
        <div class="max"><div class="load"></div></div>
        {items}
        <div class="max"><div class="load"></div></div>
        {pager}
    ',
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
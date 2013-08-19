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
        {items}
        {pager}
    ',
    'pager' => array(
        'class' => 'CLinkPager',
        'maxButtonCount' => 5,
    ),
    'beforeAjaxUpdate' => '
        function() {
            $(".list-view .max").hide();
            $(".list-view .max").fadeIn("slow");
        }
    ',
    'afterAjaxUpdate' => '
        function() {
            $(".items").hide();
            $(".items").fadeIn("slow");
        }
    ',
));

$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target' => 'a.fancybox',
    'config' => array(
        'width' => '85%',
        'height' => '85%'
    )
));
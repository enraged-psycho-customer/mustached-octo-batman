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
        <div class="item pager_wrap">
            {pager}
        </div>
    ',
    'ajaxUpdate' => false,
    'pager' => array(
        'class' => 'LinkPager',
        'maxButtonCount' => 1,
        'header' => 'Страница',
        'prevPageLabel' => CHtml::image($this->assetsUrl . '/images/pager_left.png'),
        'nextPageLabel' => CHtml::image($this->assetsUrl . '/images/pager_right.png'),
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
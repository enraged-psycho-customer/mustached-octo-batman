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

<?php
$script = <<< EOD
    $("div.item a").on("click", function(e) {
        e.preventDefault();
        var itemId = $(this).parent().parent().attr('data-id');
        var itemSelector = '#item_' + itemId;
        var commentsSelector = '#comments_' + itemId;
        var requestUrl = $(this).attr('href') + '?modal';

        $(itemSelector).find('div.number').html('<div class="loader"></div>');

        $.ajax(requestUrl)
            .done(function(data){
                $(itemSelector).replaceWith(data);
                $(itemSelector).addClass('active');
                $(commentsSelector).addClass('active');

                var target_offset = $(commentsSelector).offset();
                var target_top = target_offset.top;

                $('html, body').animate({scrollTop: target_top}, 1500);
            })
            .fail(function() { alert("Произошла ошибка. Повторите свой запрос позднее."); })

        return false;
    });
EOD;

Yii::app()->clientScript->registerScript('itemLive', $script, CClientScript::POS_END);
?>

<?php $this->renderPartial('_filters'); ?>
<?php
$this->widget('zii.widgets.CListView', array(
    'id' => 'itemsList',
    'dataProvider' => $dataProvider,
    'itemView' => $itemTemplate,
    'template' => '{items}{pager}',
    'pager' => array(
        'class' => 'CLinkPager',
        'maxButtonCount' => 7,
    ),
));
?>

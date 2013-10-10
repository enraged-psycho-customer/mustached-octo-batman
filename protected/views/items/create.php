<?php
/* @var $this ItemsController */
/* @var $model Items */
/* @var $form CActiveForm */
?>

<?php
$script = <<< EOD
    var contentTypes = {
        1: 'form_quote',
        2: 'form_image',
        3: 'form_inquisition'
    };

    function switchContentType(id) {
        for (var i in contentTypes) $('.' + contentTypes[i]).hide();
        $('.' + contentTypes[id]).fadeIn(300);
    }

    $("a.scroll").live("click", function(e) {
        e.preventDefault();
        var direction = $(this).attr('data-dir');

        if (direction == 'up') {
            optionValue = $('select#category option:selected').prev().val();
            optionText = $('select#category option:selected').prev().html();

            if (typeof optionValue === 'undefined') {
                optionValue = $('select#category option').last().val();
                optionText = $('select#category option').last().html();
            }
        }
        else {
            optionValue = $('select#category option:selected').next().val();
            optionText = $('select#category option:selected').next().html();

            if (typeof optionValue === 'undefined') {
                optionValue = $('select#category option').first().val();
                optionText = $('select#category option').first().html();
            }
        }

        console.log(optionValue);

        $('select#category').val(optionValue);
        $('div.selectText').html(optionText);
        switchContentType(optionValue);

        return false;
    });

    $("a.scrollbar").live("click", function(e) {
        e.preventDefault();
        var direction = $(this).attr('data-dir');
        var element = $('textarea#text');
        var scrollDelta = parseInt(Math.floor(element.get(0).scrollHeight / 10));

        if (direction == 'up') {
            var scrollValue = element.scrollTop() - scrollDelta;
        }
        else {
            var scrollValue = element.scrollTop() + scrollDelta;
        }

        element.scrollTop(scrollValue);

        return false;
    });
EOD;

Yii::app()->clientScript->registerScript('scrollSelect', $script, CClientScript::POS_END);

if (isset($model->category)) {
    Yii::app()->clientScript->registerScript('switchContentType', 'switchContentType(' . $model->category . ')', CClientScript::POS_READY);
}
?>

<?php if ($this->stage >= Stages::STAGE_INIT): ?>
    <?php $this->renderPartial('forms/_quote', array('model' => $model)); ?>
    <?php $this->renderPartial('forms/_image', array('model' => $model)); ?>
<?php endif; ?>

<?php if ($this->stage >= Stages::STAGE_INQUISITION): ?>
    <?php $this->renderPartial('forms/_inquisition', array('model' => $model)); ?>
<?php endif; ?>

<?php
$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target' => 'a.rules',
    'config' => array(
        'width' => '99%',
        'height' => '99%'
    ),
));
?>
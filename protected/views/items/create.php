<?php
/* @var $this ItemsController */
/* @var $model Items */
/* @var $form CActiveForm */

$this->breadcrumbs = array(
    'Items' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Items', 'url' => array('index')),
    array('label' => 'Manage Items', 'url' => array('admin')),
);
?>

<?php
$script = <<< EOD
    $("a.scroll").live("click", function(e) {
        e.preventDefault();
        var direction = $(this).attr('data-dir');

        if (direction == 'up') {
            optionValue = $('select#category option:selected').prev().val();
            if (typeof optionValue === 'undefined') {
                optionValue = $('select#category option').last().val();
            }
        }
        else {
            optionValue = $('select#category option:selected').next().val();
        }

        $('select#category').val(optionValue);

        return false;
    });

    $("a.scrollbar").live("click", function(e) {
        e.preventDefault();
        var direction = $(this).attr('data-dir');
        var element = $('textarea#text');

        if (direction == 'up') {
            var scrollValue = -1 * $('textarea#text').height();
        }
        else {
            var scrollValue = $('textarea#text').height();
        }


        return false;
    });
EOD;

Yii::app()->clientScript->registerScript('scrollSelect', $script, CClientScript::POS_END);
?>

<div id="createForm">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'items-form',
        'enableAjaxValidation' => false,
    )); ?>

    <div class="category">
        <div>
            <a class="scroll" data-dir="up" href="javascript:void(0)"><i class="sprite sprite_form_arrow_up"></i></a>
        </div>
        <div>
            <?php echo $form->dropDownList($model, 'category', $model->getCategories(), array('id' => 'category', 'disabled' => 'disabled')); ?>
        </div>
        <div>
            <a class="scroll" data-dir="down" href="javascript:void(0)"><i class="sprite sprite_form_arrow_down"></i></a>
        </div>
    </div>

    <div class="errors">
        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="text">
        <?php echo $form->textArea($model, 'content', array('id' => 'text')); ?>

        <!--
        <a class="scrollbar" data-dir="up" href="javascript:void(0)">
            <i class="sprite sprite_scroll_up"></i>
        </a>
        <a class="scrollbar" data-dir="down" href="javascript:void(0)">
            <i class="sprite sprite_scroll_down"></i>
        </a>
        -->
    </div>

    <div class="email">
        <label for="email"><span class="hint">Ваш e-mail:</span></label>
        <?php echo $form->textField($model, 'email', array('id' => 'email')); ?>
    </div>

    <div class="buttons">
        <div>
            <button class="checkbox" type="submit"><i class="sprite sprite_checkbox"></i></button>
        </div>
        <div class="agreement">
            <span class="hint">Я прочитал <?php echo CHtml::link('правила', array('/site/page', 'view' => 'rules'), array('class' => 'hint')) ?>, и гарантирую,<br/> что не буду визжать как сучка</span>
        </div>
    </div>

    <div class="clear"></div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
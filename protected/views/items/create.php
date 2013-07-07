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

        console.log(optionValue + " / " + optionText);

        $('select#category').val(optionValue);
        $('div.selectText').html(optionText);

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
?>

<div id="createForm">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'items-form',
        'enableAjaxValidation' => false,
    )); ?>

    <div class="category">
        <div>
            <a class="scroll" data-dir="up" href="javascript:void(0)"><i class="icon icon-form_arrow_up"></i></a>
        </div>
        <div>
            <div class="selectText">Новая цитата</div>
            <?php echo $form->dropDownList($model, 'category', $model->getCategories(), array('id' => 'category', 'style' => 'display: none')); ?>
        </div>
        <div>
            <a class="scroll" data-dir="down" href="javascript:void(0)"><i class="icon icon-form_arrow_down"></i></a>
        </div>
    </div>

    <div class="errors">
        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="text">
        <?php echo $form->textArea($model, 'content', array('id' => 'text')); ?>

        <div class="textareaScrollbar">
            <a class="scrollbar" data-dir="up" href="javascript:void(0)">
                <i class="icon icon-scroll_up"></i>
            </a>
            <br>
            <a class="scrollbar" data-dir="down" href="javascript:void(0)">
                <i class="icon icon-scroll_down"></i>
            </a>
        </div>
    </div>

    <div class="clear"></div>

    <div class="email">
        <div class="label">
            <label for="email">Ваш e-mail:</label>
        </div>
        <?php echo $form->textField($model, 'email', array('id' => 'email')); ?>
        <div>
            <span class="pad hint small">На него будут приходить уведомления о новых комментариях</span>
        </div>
    </div>

    <div class="buttons">
        <div>
            <button class="checkbox" type="submit"><i class="icon icon-checkbox"></i></button>
        </div>
        <div class="agreement">
            Я прочитал <?php echo CHtml::link('правила', array('/site/page', 'view' => 'rules'), array('class' => 'hint')) ?>, и гарантирую,<br/> что не буду визжать как сучка
        </div>
    </div>

    <div class="clear"></div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
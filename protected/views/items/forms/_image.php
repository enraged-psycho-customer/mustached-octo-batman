<?php
/* @var $this ItemsController */
/* @var $model Items */
/* @var $form CActiveForm */
?>

<div id="createForm" class="form_image">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'enableClientValidation' => true,
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
        <?php
        $this->widget('CocoWidget', array(
            'id' => 'upload_image',
            'allowedExtensions' => array('jpg', 'png'), // server-side mime-type validated
            'uploadDir' => Items::IMAGE_TEMP_DIR,
            'receptorClassName' => 'application.models.Items',
            'methodName' => 'onImageUploaded',
            'maxUploads' => 1, // defaults to -1 (unlimited)
            'maxUploadsReachMessage' => '',
            'multipleFileSelection' => false,
            'defaultControllerName' => 'items',
            'buttonText' => CHtml::image($this->assetsUrl . '/images/upload.png'),
            'dropFilesText' => 'Бросайте файл сюда',
        ));
        ?>
    </div>

    <div class="clear"></div>

    <div class="email">
        <div class="label">
            <label for="email">Ваш e-mail:</label>
        </div>
        <?php echo $form->textField($model, 'email', array('id' => 'email', 'placeholder' => 'yourname@example.com')); ?>
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
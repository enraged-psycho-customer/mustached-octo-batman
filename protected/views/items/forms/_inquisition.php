<?php
/* @var $this ItemsController */
/* @var $model Items */
/* @var $form CActiveForm */
?>

<div id="createForm" class="form_inquisition">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'enableClientValidation' => true,
    )); ?>

    <div class="category">
        <div>
            <a class="scroll" data-dir="up" href="javascript:void(0)"><i class="icon icon-arrow_small_top"></i></a>
        </div>
        <div>
            <div class="selectText">Новая цитата</div>
            <?php echo $form->dropDownList($model, 'category', $model->getCategories(), array('id' => 'category', 'style' => 'display: none')); ?>
        </div>
        <div>
            <a class="scroll" data-dir="down" href="javascript:void(0)"><i class="icon icon-arrow_small_bottom"></i></a>
        </div>
    </div>

    <div class="errors">
        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="text" id="text_inquisition">
        <div class="email">
            <?php echo $form->textField($model, 'title', array('id' => 'title', 'placeholder' => 'Введите имя грешника сюда')); ?>
        </div>
        <br/><br/>

        <table>
            <tr>
                <td>
                    <div class="email">
                        <div class="label">
                            <label for="content">Текст обвинения:</label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="textarea" rowspan="2">
                    <?php echo $form->textArea($model, 'content', array('id' => 'text')); ?>
                </td>
                <td>
                    <a class="scrollbar" data-dir="up" href="javascript:void(0)">
                        <i class="icon icon-scroll_up"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="bottom">
                    <a class="scrollbar" data-dir="down" href="javascript:void(0)">
                        <i class="icon icon-scroll_down"></i>
                    </a>
                </td>
            </tr>
        </table>
        <br/><br/>

        <div class="email">
            <div class="label">
                <label for="content">К делу прилагаются файлы:</label>
            </div>
        </div>
        <?php
        $this->widget('CocoWidget', array(
            'id' => 'upload_files',
            'allowedExtensions' => array('jpg', 'png', 'doc', 'docx', 'txt'), // server-side mime-type validated
            'uploadDir' => Items::IMAGE_TEMP_DIR,
            'receptorClassName' => 'application.models.Items',
            'methodName' => 'onFilesUploaded',
            'maxUploads' => Items::FILE_LIMIT, // defaults to -1 (unlimited)
            'maxUploadsReachMessage' => 'Максимальное число файлов - 5',
            'multipleFileSelection' => true,
            'defaultControllerName' => 'items',
            'buttonText' => CHtml::image($this->assetsUrl . '/images/upload.png'),
            'dropFilesText' => 'Бросайте файлы сюда',
        ));
        ?>
    </div>

    <div class="clear"></div>

    <div class="email">
        <div class="helper">
            <table>
                <tr>
                    <td>
                        <div class="label"><label for="email">Ваш e-mail:</label></div>
                    </td>
                    <td>
                        <?php echo $form->textField($model, 'email', array('id' => 'email', 'placeholder' => 'yourname@example.com')); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="left">
                        <span class="hint small">На него <i>возможно, когда-нибудь</i> будут<br/> приходить уведомления о новых комментариях</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="buttons">
        <div>
            <button class="checkbox" type="submit"><i class="icon icon-checkbox"></i></button>
        </div>
        <div class="agreement">
            Я прочитал <?php echo CHtml::link('правила', array('/site/page', 'view' => 'rules'), array('class' => 'hint', 'target' => '_blank')) ?>, и гарантирую,<br/> что не буду визжать как сучка
        </div>
    </div>

    <div class="clear"></div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
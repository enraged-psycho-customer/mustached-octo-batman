<div class="<?php echo $class; ?>">
    <div class="comment">
        <div class="avatar">
            <a href="javascript:void(0)" class="avatar_switch">
                <i class="icon icon-form_arrow_up"></i>
            </a>
            <span><i class="avatar icon icon-avatar_boy"></i></span>
            <a href="javascript:void(0)" class="avatar_switch">
                <i class="icon icon-form_arrow_down"></i>
            </a>
        </div>
        <div class="text">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'comment-form',
                'enableAjaxValidation' => false,
            )); ?>

            <?php echo $form->hiddenField($model, 'avatar', array('class' => 'avatar_field')); ?>
            <?php echo $form->hiddenField($model, 'parent_id', array('class' => 'parent_id')); ?>

            <div class="textarea">
                <?php echo $form->textArea($model, 'content'); ?>
                <span><button class="checkbox" type="button"><i class="icon icon-checkbox"></i></button></span>
            </div>

            <div class="captcha">
                <?php
                $this->widget('CCaptcha',
                    array(
                        'captchaAction' => 'site/captcha',
                        'showRefreshButton' => false,
                        'clickableImage' => true,
                        'imageOptions' => array(
                            'title' => 'Кликните для обновления изображение'
                        ),
                    )
                );
                ?>
                <?php echo $form->textField($model, 'captcha'); ?>
                <span><button class="checkbox" type="submit"><i class="icon icon-checkbox"></i></button></span>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
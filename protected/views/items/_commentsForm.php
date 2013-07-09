<div class="<?php echo $class; ?>">
    <div class="containerForm">
        <div class="avatar">
            <a href="javascript:void(0)" class="avatar_switch up">
                <i class="icon icon-form_arrow_up"></i>
            </a>
            <a href="javascript:void(0)" title="Аватар"><i class="avatar avatars avatar_1" data-avatar="1"></i></a>
            <a href="javascript:void(0)" class="avatar_switch down">
                <i class="icon icon-form_arrow_down"></i>
            </a>
        </div>
        <div class="form">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'comment-form',
                'enableAjaxValidation' => false,
            )); ?>

            <?php echo $form->hiddenField($model, 'avatar', array('class' => 'avatar_field')); ?>
            <?php echo $form->hiddenField($model, 'parent_id', array('class' => 'parent_id')); ?>

            <div class="controls">
                <div class="textarea">
                    <img src="<?php echo $this->assetsUrl; ?>/images/comment_arrow.png"/>
                    <?php echo $form->textArea($model, 'content'); ?>
                </div>

                <div class="button">
                    <button type="button"><i class="icon icon-checkbox"></i></button>
                </div>
            </div>

            <div class="captcha">
                <div><?php echo $form->textField($model, 'captcha'); ?></div>
                <div>
                    <?php
                    $this->widget('CCaptcha',
                        array(
                            'captchaAction' => 'items/captcha',
                            'showRefreshButton' => false,
                            'clickableImage' => true,
                            'imageOptions' => array(
                                'title' => 'Кликните для обновления изображения'
                            ),
                        )
                    );
                    ?>
                </div>
                <div class="submit"><button class="checkbox" type="submit"><i class="icon icon-checkbox"></i></button></div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
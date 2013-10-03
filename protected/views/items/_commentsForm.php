<div class="<?php echo $class; ?>">
    <div class="containerForm">
        <div class="avatar">
            <?php if (Yii::app()->user->isGuest): ?>
                <a href="javascript:void(0)" class="avatar_switch up">
                    <i class="icon icon-form_arrow_up"></i>
                </a>
                <a href="javascript:void(0)" title="Аватар"><i class="avatar avatars avatar_1" data-avatar="1"></i></a>
                <a href="javascript:void(0)" class="avatar_switch down">
                    <i class="icon icon-form_arrow_down"></i>
                </a>
            <?php else: ?>
                <a class="admin" href="javascript:void(0)" title="Аватар"><i class="avatar avatars avatar_0" data-avatar="0"></i></a>
            <?php endif; ?>
        </div>
        <div class="form">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'comments-form',
                'enableAjaxValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
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
                <div class="submit">
                    <?php echo CHtml::ajaxSubmitButton('', $this->createAbsoluteUrl('/' . $item->id), array(
                        'dataType' => 'json',
                        'success' => 'js:function(data) {
                            var message = "";
                            var item = $("#item_" + ' . $item->id . ');

                            if (data.success == undefined) {
                                var i = 0;
                                for (var key in data) {
                                    message = data[key];
                                    if (typeof(first) !== \'function\') {
                                        break;
                                    }
                                }

                                alert(message);
                            } else {
                                // Add comment and hide comment forms
                                var commentHtml = $(data.commentHtml);
                                var parentComment = null;

                                if (data.parent_id == 0) {
                                    parentComment = item.find(".comment").last();
                                    item.find(".commentsFormBottom .controls").show();
                                    item.find(".commentsFormBottom textarea").val("");
                                    item.find(".commentsFormBottom .captcha").hide();
                                    item.find(".commentsFormBottom input").val("");
                                } else {
                                    parentComment = item.find(".comment_" + data.parent_id);
                                    item.find(".commentsFormNested").fadeOut(300);
                                }

                                parentComment.after(commentHtml);
                                $(commentHtml).hide().fadeIn(300);
                            }

                            item.find("div.captcha img").trigger("click");
                        }'
                    ), array('class' => 'checkbox')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
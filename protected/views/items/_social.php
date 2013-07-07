<div class="social">
    <a class="close" href="javascript:void(0)" title="Скрыть">
        <i class="icon icon-close"></i>
    </a>
    <span class="wrap_like_<?php echo $model->id; ?>">
        <?php if ($hasVoted): ?>
            <i class="icon icon-like_active" title="Вы уже голосовали за данный контент"></i>
        <?php else: ?>
            <?php
            echo CHtml::ajaxLink(
                '<i class="icon icon-like"></i>',
                Yii::app()->createUrl('/items/vote/', array('id' => $model->id)),
                array( // ajaxOptions
                    'type' => 'POST',
                    'beforeSend' => "function(request) {
                        $('a.like_" . $model->id . "').html('<div class=\"loader\"></div>');
                    }",
                    'success' => "function(data) {
                        data = JSON.parse(data);
                        $('span.wrap_like_" . $model->id . "').html('<i class=\"icon icon-like_active\"></i>');
                        alert(data.msg);
                    }",
                ),
                array( //htmlOptions
                    'href' => Yii::app()->createUrl('/items/vote/', array('id' => $model->id)),
                    'class' => 'like_' . $model->id,
                    'id' => 'ajaxVota_' . $model->id
                )
            );
            ?>
        <?php endif; ?>
    </span>
    <a href="https://vk.com/share.php?url=<?php echo Yii::app()->createAbsoluteUrl('/' . $model->id); ?>&text=Адовые клиенты!" title="Поделиться на VK" target="_blank">
        <i class="icon icon-vk"></i>
    </a>
    <a href="https://twitter.com/share/?url=<?php echo Yii::app()->createAbsoluteUrl('/' . $model->id); ?>&title=Адовые клиенты!" title="Поделиться на Twitter" target="_blank">
        <i class="icon icon-twitter"></i>
    </a>
    <a href="javascript:void(0)" title="Поделиться на Facebook">
        <i class="icon icon-facebook"></i>
    </a>
</div>
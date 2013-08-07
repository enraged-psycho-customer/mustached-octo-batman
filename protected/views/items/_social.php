<div class="<?php echo $class; ?> social-common">
    <a class="close" href="javascript:void(0)" title="Скрыть">
        <i class="icon icon-close"></i>
    </a>
    <a class="externalToggle" href="javascript:void(0)" title="Поделить в социальных сетях">
        <i class="icon icon-like"></i>
    </a>
    <?php $absoluteUrl = Yii::app()->createAbsoluteUrl('/' . $model->id); ?>
    <span class="external">
        <a href="https://vk.com/share.php?url=<?php echo $absoluteUrl; ?>&title=Адовые клиенты!" title="Поделиться на VK" target="_blank">
            <i class="icon icon-vk"></i>
        </a>
        <a href="https://twitter.com/share/?url=<?php echo $absoluteUrl; ?>&text=Адовые клиенты!" title="Поделиться на Twitter" target="_blank">
            <i class="icon icon-twitter"></i>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($absoluteUrl); ?>" title="Поделиться на Facebook">
            <i class="icon icon-facebook"></i>
        </a>
    </span>
</div>
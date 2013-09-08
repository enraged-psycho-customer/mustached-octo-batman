<div class="quote_content">
<?php if ($model->category == Items::CATEGORY_QUOTES): ?>
    <?php
    $string = $model->content;
    if (!$modal && $list && mb_strlen($string, 'utf-8') >= Items::SPOILER_LIMIT){
        $string = mb_substr($string, 0, 700 - 5, 'utf-8') .
            "..." .
            "<br>".
            CHtml::link("Читать дальше", 'javascript:void(0)');
    }
    echo $string;
    ?>
<?php elseif ($model->category == Items::CATEGORY_IMAGES): ?>
    <?php
    $thumbnail = $model->getImageDir() . 'thumb_' . $model->image;
    $fullsize = $model->getImageDir() . $model->image;

    if ($list) {    // In list
        echo CHtml::image($thumbnail);
    } else {        // Single item
        echo CHtml::image($fullsize, '', array(
            'id' => 'image_' . $model->id,
            'class' => 'image_item image_item_' . $model->id,
            'width' => '100%',
        ));

        echo CHtml::image($fullsize, '', array(
            'class' => 'pivot',
        ));
    }
    ?>
<?php elseif ($model->category == Items::CATEGORY_INQUISITION): ?>
    <h1><?php echo CHtml::encode($model->title); ?></h1>
    <div><?php echo $model->content; ?></div>
    <br/><br/>
    <div>
        <?php $files = array(); ?>
        <?php foreach ($model->files as $file): ?>
            <?php $files[] = CHtml::link($file->filename, $model->getImageDir() . $file->filename); ?>
        <?php endforeach; ?>
        <?php if (count($files)) echo 'К делу прилагается:' . implode(", ", $files); ?>
    </div>
<?php endif; ?>
</div>

<?php if (!$list): ?>
<div class="yandex">
    <script type="text/javascript" src="//yandex.st/share/share.js"
            charset="utf-8"></script>
    <div class="yashare-auto-init" data-yashareL10n="ru"
         data-yashareType="button" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir"></div>
</div>
<?php endif; ?>
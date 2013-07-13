<?php if ($model->category == Items::CATEGORY_QUOTES): ?>
    <?php echo $model->content; ?>
<?php elseif ($model->category == Items::CATEGORY_IMAGES): ?>
    <?php
    $thumbnail = $model->getImageDir() . 'thumb_' . $model->image;
    $fullsize = $model->getImageDir() . $model->image;
    echo CHtml::link(CHtml::image($thumbnail), array('/' . $model->id), array(
        'class' => 'fancybox iframe'
    ));
    ?>
<?php endif; ?>
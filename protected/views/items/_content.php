<div class="quote_content">
<?php if ($model->category == Items::CATEGORY_QUOTES): ?>
    <?php echo $model->content; ?>
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
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
<?php elseif ($model->category == Items::CATEGORY_INQUISITION): ?>
    <h1><?php echo CHtml::encode($model->title); ?></h1>
    <div><?php echo $model->content; ?></div>
    <br/><br/>
    <div>К делу прилагается:
    <?php $files = array(); ?>
    <?php foreach ($model->files as $file): ?>
        <?php $files[] = CHtml::link($file->filename, $model->getImageDir() . $file->filename); ?>
    <?php endforeach; ?>
    <?php echo implode(", ", $files); ?>
    <?php if (!count($files)) echo 'ничего'; ?>
    </div>
<?php endif; ?>
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
    <div class="image-block">
        <?php
        $thumbnail = $model->getImageDir() . 'thumb_' . $model->image;
        $fullsize = $model->getImageDir() . $model->image;

        if ($list) {    // In list
            echo CHtml::image($thumbnail);
        } else {        // Single item
            echo CHtml::image($fullsize, '', array(
                'id' => 'image_' . $model->id,
                'class' => 'image_item image_item_' . $model->id,
            ));

            echo CHtml::image($fullsize, '', array(
                'class' => 'pivot',
            ));

            if($model->comments)
                foreach($model->comments as $comment) { ?>
                    <div class="hm" style="position: absolute; top: <?php echo $comment->y?>%; left: <?php echo $comment->x?>%;">
                        <div class="border">
                            <i class="glow glow_<?php echo $comment->avatar; ?>">
                                <div class="com-text">
                                    <?php echo CHtml::encode($comment->content)?>
                                    <div class="com-arr"></div>
                                </div>
                            </i>
                        </div>
                    </div>
                <?php }
        }
        ?>
    </div>
<?php elseif ($model->category == Items::CATEGORY_INQUISITION): ?>
    <h1><?php echo CHtml::encode($model->title); ?></h1>
    <div><?php echo $model->content; ?></div>
    <br/><br/>
    <div>
        <?php $files = array(); ?>
        <?php foreach ($model->files as $file): ?>
            <?php $files[] = CHtml::link($file->filename, $model->getImageDir() . $file->filename, array('class' => 'file')); ?>
        <?php endforeach; ?>
        <?php if (count($files)) echo 'К делу прилагается: ' . implode(", ", $files); ?>
    </div>
<?php endif; ?>
</div>

<?php if (!$list): ?>
    <?php
    echo $this->renderPartial('application.views.partials.yandex', array(
        'model' => $model,
        'thumbnail' => isset($thumbnail) ? $thumbnail : null
    ));
    ?>
<?php endif; ?>
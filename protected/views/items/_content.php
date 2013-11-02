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
    <div class="image-block" >
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

            ?>
            <div id="block_<?php echo $model->id?>">
            <?php
            if($model->comments)
                foreach($model->comments as $comment) {
                    if($comment->x!=null&&$comment->y!=null) {
                    ?>
                    <div class="hm" style="position: absolute; top: <?php echo $comment->y?>%; left: <?php echo $comment->x?>%;">
                        <div class="border">
                            <i class="glow glow_<?php echo $comment->avatar; ?>">
                                <div class="com-text">
                                    <div class="text">
                                        <?php echo CHtml::encode($comment->content)?>
                                    </div>
                                    <div class="com-arr"></div>
                                </div>
                            </i>
                        </div>
                    </div>
                <?php }}?>
            </div>
        <?php
            Yii::app()->clientScript->registerScript('init_com_add','
            $("#image_'.$model->id.'").live("click",function(e){
                $(".hm").addClass("hm-off");

                var xClick = e.pageX - $(this).offset().left - 10;
                var yClick = e.pageY - $(this).offset().top - 40;

                xClick = pxToPercent(xClick,this,"width");
                yClick = pxToPercent(yClick,this,"height");

                if($("#commentForm").length==1)
                {
                    $("#commentForm").css({left:xClick+"%",top:yClick+"%"});
                    $("#Comments_x").val(xClick);
                    $("#Comments_y").val(yClick);
                }
                else
                {
                    $.ajax({
                        url: "/comments/create",
                        type: "post",
                        data: ({id:'.$model->id.',x:xClick,y:yClick}),
                        success: function(data)
                        {
                            $("#item_'.$model->id.' .image-block").append(data);
                            $("#commentForm").css({left:xClick+"%",top:yClick+"%"}).fadeIn();
                        }
                    });
                }
            });

            $(".cancel-note").live("click",function(){
                $("#commentForm").fadeOut(function(){$(this).remove()});
                $(".hm").removeClass("hm-off");
            });

            $(".save-note").live("click",function(){
                if($("#Comments_content").val()!="")
                {
                    $("#Comments_avatar").val($(".glow_current i").attr("data-avatar"));
                    $.ajax({
                        url: "/comments/create",
                        type: "post",
                        data: $(".save-note").parents("form").serialize(),
                        success: function(data){
                            if(data==true)
                            {
                                $.ajax({
                                    url: "/comments/refresh",
                                    data: {id: '.$model->id.'},
                                    success: function(data)
                                    {
                                        if(data!="error") {
                                            $("#commentForm").fadeOut(function(){$(this).remove()});
                                            $(".hm").removeClass("hm-off");
                                            $("#block_'.$model->id.'").html(data);
                                        }
                                    }
                                });
                            }
                        }
                    });
                }
            });

            function pxToPercent(pixel,image,type)
            {
                if(type=="width")
                    return parseInt((100 / image.width) * pixel);
                else
                    return parseInt((100 / image.height) * pixel);
            }
            ');
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
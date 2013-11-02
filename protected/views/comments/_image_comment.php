<?php
if($comments)
    foreach($comments as $comment) {
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
<div class="yandex">
    <?php
    $link = $this->createAbsoluteUrl('/' . $model->id);

    $config = array(
        'element' => 'ya_share',
        'link' => $this->createAbsoluteUrl('/' . $model->id),
        //'title' => $title,
        //'description' => 'testets',
        'elementStyle' => array(
            'quickServices' => array(
                'vkontakte',
                'facebook',
                'twitter'
            ),
            'type' => 'none'
        ),
    );

    if (isset($thumbnail)) $config['image'] = $this->createAbsoluteUrl($thumbnail);
    $json_config = json_encode((object)$config);
    ?>


    <script type="text/javascript">
        //var YaShareInstance = new Ya.share(<?php echo $json_config; ?>);
    </script>
    <div id="ya_share">
        <a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($link); ?>">
            <i class="icon icon-facebook"></i>
        </a>
    </div>
</div>
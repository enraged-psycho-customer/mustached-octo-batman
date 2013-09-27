<div class="yandex">
    <?php
    $config = array(
        'element' => 'ya_share',
        'link' => $this->createAbsoluteUrl('/' . $model->id),
        'title' => implode(" - ", array(Yii::app()->name, "№" . $model->id)),
        'description' => isset($string) ? $string : '',
        'elementStyle' => array(
            'quickServices' => array(
                'vkontakte',
                'facebook',
                'twitter'
            ),
            'type' => 'none'
        )
    );

    if (isset($thumbnail)) $config['image'] = $this->createAbsoluteUrl($thumbnail);
    $json_config = json_encode((object)$config);
    ?>


    <script type="text/javascript">
        var YaShareInstance = new Ya.share(<?php echo $json_config; ?>);
    </script>
    <div id="ya_share"></div>
</div>
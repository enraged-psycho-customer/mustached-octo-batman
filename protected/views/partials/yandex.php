<div class="yandex">
    <?php
    $title_parts = array(Yii::app()->name);
    $category = Stages::getCategory($this->category);
    if (!is_null($category)) $title_parts[] = $category;
    $title = implode(" - ", $title_parts);

    $link = $this->createAbsoluteUrl('/' . $model->id);

    $config = array(
        'element' => 'ya_share',
        'link' => $link,
        'title' => $title,
        'elementStyle' => array(
            'quickServices' => array(
                'vkontakte',
                'facebook',
                'twitter'
            ),
            'type' => 'none'
        ),
        'serviceSpecific' => array(
            'twitter' => array(
                'title' => isset($description) ? $description : '',
            )
        ),
    );

    if (isset($thumbnail)) $config['image'] = $this->createAbsoluteUrl($thumbnail);
    $config['description'] = $this->viewLink;
    if ($model->category != Items::CATEGORY_IMAGES) {
        $config['description'] = mb_substr($model->content, 0, 100, 'utf-8') . "...";
    }
    $json_config = json_encode((object)$config);
    ?>


    <script type="text/javascript">
        var YaShareInstance = new Ya.share(<?php echo $json_config; ?>);
    </script>
    <div id="ya_share">
    </div>
</div>
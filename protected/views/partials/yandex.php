<div class="yandex">
    <?php
    $title_parts = array(Yii::app()->name);
    $category = Stages::getCategory($this->category);
    if (!is_null($category)) $title_parts[] = $category;
    $title = implode(" - ", $title_parts);

    $image = null;
    if (isset($thumbnail)) $image = $this->createAbsoluteUrl($thumbnail);

    $description = $this->viewLink;
    if ($model->category != Items::CATEGORY_IMAGES) {
        $description = mb_substr($this->description, 0, 100, 'utf-8');
        $twitterTitle = $description;
    } else {
        $twitterTitle = $title;
    }

    $link = $this->createAbsoluteUrl('/' . $model->id);

    $config = array(
        'element' => 'ya_share',
        'link' => $link,
        'image' => $image,
        'title' => $title,
        'description' => $description,
        'elementStyle' => array(
            'quickServices' => array(
                'vkontakte',
                'facebook',
                'twitter'
            ),
            'type' => 'none'
        ),
        'serviceSpecific' => array(
            'facebook' => array(
                'link' => implode('?', array($link, rand(100000, 999999)))
            ),
            'twitter' => array(
                'title' => $twitterTitle,
            )
        ),
    );

    $json_config = json_encode((object)$config);
    ?>


    <script type="text/javascript">
        var YaShareInstance = new Ya.share(<?php echo $json_config; ?>);
    </script>
    <div id="ya_share">
    </div>
</div>
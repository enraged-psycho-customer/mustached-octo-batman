<div class="platform">
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <div class="fb-like"
         data-href="<?php echo $url; ?>"
         data-width="450"
         data-layout="button_count"
         data-show-faces="true"
         data-send="false"></div>
</div>

<div class="platform">
<?php if (YII_DEBUG): ?>
    <script type="text/javascript">
        VK.init({apiId: 3830215, onlyWidgets: true});
    </script>

    <!-- Put this div tag to the place, where the Like block will be -->
    <div id="vk_like"></div>
    <script type="text/javascript">
        VK.Widgets.Like("vk_like", {type: "mini"});
    </script>
<?php else: ?>
    <script type="text/javascript">
        VK.init({apiId: 3830212, onlyWidgets: true});
    </script>

    <!-- Put this div tag to the place, where the Like block will be -->
    <div id="vk_like"></div>
    <script type="text/javascript">
        VK.Widgets.Like("vk_like", {type: "mini"});
    </script>
<?php endif; ?>
</div>

<div class="platform">
    <a href="https://twitter.com/share" class="twitter-share-button" data-lang="ru">Твитнуть</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</div>
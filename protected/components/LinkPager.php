<?php
class LinkPager extends CLinkPager
{
    public $options = array(
        'history' => false,
        'triggerPageTreshold' => 1,
        'trigger' => 'Load more',
       // 'onRenderComplete'=>"function(items) {console.log('We rendered ' + items.length + ' items');}",
    );

    public function init()
    {
        parent::init();
        $this->lastPageLabel = 'из ' . $this->getPageCount();

        $this->options['trigger'] = CHtml::image(Yii::app()->getController()->assetsUrl . '/images/load_more.png');

        $js = "jQuery.ias(" .
            CJavaScript::encode(
                CMap::mergeArray($this->options, array(
                    'container' => '#itemsList > .items',
                    'item' => '.item',
                    'pagination' => '#itemsList .pager',
                    'next' => '#itemsList .next:not(.disabled):not(.hidden) a',
                    'loader' => '<div class="loader"></div>',
                ))) . ");";


        $cs = Yii::app()->clientScript;
        $cs->registerScript(__CLASS__ . $this->id, $js, CClientScript::POS_READY);

    }

    public function run()
    {
        parent::run();
    }
}
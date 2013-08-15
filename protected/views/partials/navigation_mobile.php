<?php $this->widget('zii.widgets.CMenu', array(
    'itemTemplate' => '
        <a class="prev" href="javascript:void(0)"><i class="icon right icon-arrow_small_left"></i></a>
        {menu}
        <a class="next" href="javascript:void(0)"><i class="icon left icon-arrow_small_right"></i></a>
    ',
    'items' => array(
        array(
            'label' => 'Цитаты',
            'url' => array('/quotes'),
            'active' => $this->action->id == 'quotes',
            'visible' => $this->stage >= 1
        ),
        array(
            'label' => 'Картинки',
            'url' => array('/images'),
            'active' => $this->action->id == 'images',
            'visible' => $this->stage >= 1
        ),
        array(
            'label' => 'Сражения',
            'url' => array('/battles'),
            'active' => $this->action->id == 'battles',
            'visible' => $this->stage >= 4
        ),
        array(
            'label' => 'Инкивизиция',
            'url' => array('/inquisition'),
            'active' => $this->action->id == 'inquisition',
            'visible' => $this->stage >= 6
        ),
        array(
            'label' => 'Магазинчик',
            'url' => array('/shop'),
            'active' => $this->action->id == 'shop',
            'visible' => $this->stage >= 8
        ),
        array(
            'label' => 'Зал славы',
            'url' => array('/fame'),
            'active' => $this->action->id == 'fame',
            'visible' => $this->stage >= 11
        ),
    ),
)); ?>
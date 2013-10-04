<?php $this->widget('zii.widgets.CMenu', array(
    'itemTemplate' => '<i class="icon left icon-horn_left"></i>{menu}<i class="icon right icon-horn_right"></i>',
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
            'visible' => $this->stage >= Stages::STAGE_INQUISITION
        ),
        array(
            'label' => 'Магазинчик',
            'url' => array('/shop'),
            'active' => $this->action->id == 'shop',
            'visible' => $this->stage >= 8
        ),
    ),
)); ?>
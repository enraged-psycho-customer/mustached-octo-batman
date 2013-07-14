<?php
/* @var $this CommentsController */
/* @var $model Comments */
?>

<h1>Manage Comments</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'comments-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'content',
        'item_id',
        'created_at',
        'updated_at',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>

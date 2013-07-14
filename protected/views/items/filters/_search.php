<div id="search">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'searchForm',
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

    <?php echo CHtml::textField('query', isset($_GET['query']) ? $_GET['query'] : '', array('id' => 'query', 'placeholder' => 'Поиск по любой хуйне')); ?>
    <?php echo CHtml::submitButton('Искать'); ?>

    <?php $this->endWidget(); ?>
</div>
<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Ошибка';
?>

<div class="error_block">
    <h1>Ошибка <?php echo $code; ?></h1>

    <div class="error">
    <?php echo CHtml::encode($message); ?>
    </div>
</div>
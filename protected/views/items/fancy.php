<?php
/* @var $this ItemsController */
/* @var $model Items */
/* @var $form CActiveForm */
/* @var $commentModel Comments */

$fullsize = $model->getImageDir() . $model->image;
echo CHtml::image($fullsize, '', array('id' => 'toAnnotate'));
?>

<script language="javascript">
    $(window).load(function () {
        $("#toAnnotate").annotateImage({
            editable: true,
            useAjax: true,
            getUrl: "<?php echo Yii::app()->createUrl('/items/get/' . $model->id); ?>",
            saveUrl: "<?php echo Yii::app()->createUrl('/items/save/' . $model->id); ?>"
        });
    });
</script>
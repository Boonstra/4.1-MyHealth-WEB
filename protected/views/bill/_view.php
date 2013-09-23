<?php
/* @var $this BillController */
/* @var $data Bill */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br />

    <b><?php echo CHtml::encode('Total price'); //todo translation   ?>:</b> 
    <?php echo CHtml::encode($data->getTotalPrice()); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('paid'));   ?>:</b> 
    <?php echo CHtml::encode($data->paid == 0 ? 'No' : 'Yes');//todo, translation ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('payment_by'));   ?>:</b> 
    <?php echo CHtml::encode($data->payment_by == 0 ? Yii::app()->user->username : 'Insurance company');//todo, translation ?>
    <br />

</div>
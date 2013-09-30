<?php
/* @var $this BillController */
/* @var $model Bill */

$this->breadcrumbs = array(
    'Bills' => array('index'),
    $model->id,
);

?>

<h1>View Bill #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'paid',
            'value' => $model->paid == 0 ? 'No' : 'Yes', //todo, translation
        ),
        array(
            'name' => 'payment_by',
            'value' => $model->payment_by == 0 ? Yii::app()->user->username : 'Insurance company', //todo, translation
        ),
        array(
          'name'=>'Total price',  
          'value'=>$model->getTotalPrice(),  
        ),
    ),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => new CArrayDataProvider($model->orders),
    'columns' => array(
        'description',
        'code',
        'price',
    ),
));
?>

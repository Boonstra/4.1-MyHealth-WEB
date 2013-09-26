<?php
/* @var $this BillController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Bills',
);
?>

<h1>Bills</h1>

<?php
//$this->widget('zii.widgets.CListView', array(
//	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
//)); 

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'bill-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'Serie number',
            'value' => '$data->id',
        ),
        array(
            'name' => 'Total price',
            'value' => '$data->getTotalPrice()'
        ),
        array(
            'name' => 'Paid',
            'value' => '$data->paid == 0 ? "No" : "Yes"'
        ),
        array(
            'name' => 'Payment By',
            'value' => '$data->payment_by == 0 ? Yii::app()->user->username : "Insurance company"'
        ),
    ),
    'selectableRows' => 1,
    'selectionChanged' => 'function(id){ location.href = "' . $this->createUrl('view') . '/id/"+$.fn.yiiGridView.getSelection(id);}',
        )
)
?>

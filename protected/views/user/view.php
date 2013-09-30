<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'Edit profile', 'url' => array('update', 'id' => $model->id)),
);
?>

<h1>Viewing profile of: <?php echo $model->username ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'username',
        'email',
    ),
));
?>
<h2>Practitioner</h2>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => new CArrayDataProvider(array($model->practitioner)),
    'columns' => array(
        'first_name',
        'last_name',
        'email',
    ),
));

<?php
$this->breadcrumbs=array(
	'Consuments'=>array('index'),
	$model->max_value,
);

$this->menu=array(
	array('label'=>'List Consument', 'url'=>array('index')),
	array('label'=>'Create Consument', 'url'=>array('create')),
	array('label'=>'Update Consument', 'url'=>array('update', 'id'=>$model->max_value)),
	array('label'=>'Delete Consument', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->max_value),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Consument', 'url'=>array('admin')),
);
?>

<h1>View Consument #<?php echo $model->max_value; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'max_value',
		'description',
		'layout',
	),
)); ?>

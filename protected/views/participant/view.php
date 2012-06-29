<?php
$this->breadcrumbs=array(
	'Participants'=>array('index'),
	$model->email,
);

$this->menu=array(
	array('label'=>'List Participant', 'url'=>array('index')),
	array('label'=>'Create Participant', 'url'=>array('create')),
	array('label'=>'Update Participant', 'url'=>array('update', 'id'=>$model->email)),
	array('label'=>'Delete Participant', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->email),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Participant', 'url'=>array('admin')),
);
?>

<h1>View Participant #<?php echo $model->email; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'email',
		'first_name',
		'last_name',
		'result',
		'datetime',
	),
)); ?>

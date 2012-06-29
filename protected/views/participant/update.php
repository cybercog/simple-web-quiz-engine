<?php
$this->breadcrumbs=array(
	'Participants'=>array('index'),
	$model->email=>array('view','id'=>$model->email),
	'Update',
);

$this->menu=array(
	array('label'=>'List Participant', 'url'=>array('index')),
	array('label'=>'Create Participant', 'url'=>array('create')),
	array('label'=>'View Participant', 'url'=>array('view', 'id'=>$model->email)),
	array('label'=>'Manage Participant', 'url'=>array('admin')),
);
?>

<h1>Update Participant <?php echo $model->email; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
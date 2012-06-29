<?php
$this->breadcrumbs=array(
	'Consuments'=>array('index'),
	$model->max_value=>array('view','id'=>$model->max_value),
	'Update',
);

$this->menu=array(
	array('label'=>'List Consument', 'url'=>array('index')),
	array('label'=>'Create Consument', 'url'=>array('create')),
	array('label'=>'View Consument', 'url'=>array('view', 'id'=>$model->max_value)),
	array('label'=>'Manage Consument', 'url'=>array('admin')),
);
?>

<h1>Update Consument <?php echo $model->max_value; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
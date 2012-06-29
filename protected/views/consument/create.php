<?php
$this->breadcrumbs=array(
	'Consuments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Consument', 'url'=>array('index')),
	array('label'=>'Manage Consument', 'url'=>array('admin')),
);
?>

<h1>Create Consument</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
$this->breadcrumbs=array(
	'Consuments',
);

$this->menu=array(
	array('label'=>'Create Consument', 'url'=>array('create')),
	array('label'=>'Manage Consument', 'url'=>array('admin')),
);
?>

<h1>Consuments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

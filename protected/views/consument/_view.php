<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_value')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->max_value), array('view', 'id'=>$data->max_value)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('layout')); ?>:</b>
	<?php echo CHtml::encode($data->layout); ?>
	<br />


</div>
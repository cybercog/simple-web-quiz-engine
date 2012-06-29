<?php
$this->pageTitle=Yii::app()->name . ' - Wyniki';
?>

<p><?php eval($consument->description) ?></p>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>
<!--  <p>Zarejestruj się - weźmiesz udzia w losowaniu nagrody!</p> -->

<div class="form_register">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'registration-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	<table>
	<tr><td>
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'firstName'); ?>
		<?php echo $form->textField($model,'firstName'); ?>
		<?php echo $form->error($model,'firstName'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'lastName'); ?>
		<?php echo $form->textField($model,'lastName'); ?>
		<?php echo $form->error($model,'lastName'); ?>
	</div>
	
	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<!--  <div class="hint">Wpisz litery pokazane na obrazku.</div>  -->
		<?php echo $form->labelEx($model, 'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?></br>
		<?php echo $form->textField($model, 'verifyCode'); ?>
		</div>
		<?php echo $form->error($model, 'verifyCode'); ?>
	</div>
	<?php endif; ?>
	</td>
	<td style="width:15px"></td>
	<td style="vertical-align: bottom">
	<div class="row buttons">
		<?php echo CHtml::submitButton('Wyślij'); ?>
	</div>
	</td></tr>
	</table>
<?php $this->endWidget(); ?>
</div><!-- form -->

<?php endif; ?>
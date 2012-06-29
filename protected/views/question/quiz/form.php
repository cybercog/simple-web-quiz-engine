<?php
/*echo $event->sender->menu->run();*/
echo '<div class="question_header">Plansza '.$event->sender->currentStep.' z '.$event->sender->stepCount.'</div>';
if (isset($form)) {
	echo CHtml::tag('div',array('class'=>'form'),$form->render());
} else {
	echo $question->content;
	echo CHtml::submitButton('Next');
}

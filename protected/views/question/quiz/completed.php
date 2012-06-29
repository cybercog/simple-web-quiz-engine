<?php

if ($totalPoints < 100) {
	$consumentType = "Jestes BEE!"	;
} elseif ($totalPoints > 100 && $totalPoints < 200) {
	$consumentType = "Jestes umiarkowany!";
} else {
	$consumentType = "Jestes super-konsumentem!!! :)";
}

//$correctAnswers=0;
//$tbody = '<tbody>';
//foreach ($results as $step=>$result):
	
//	$tbody .= '<tr>';
//	$tbody .= '<th>'.$result->answer->question->content.'</th>';
//	$tbody .= '<td>'.htmlentities($result->answer->answer).'</td>';
//	$tbody .= '<td>'.$result->answer->value.'</td></tr>';
//	$correctAnswers= $correctAnswers + $result->answer->value;
//endforeach;
//$tbody .= '</tbody>';
?>
<h2>Quiz Results</h2>

<h3><?php echo $consumentType; ?></h3>




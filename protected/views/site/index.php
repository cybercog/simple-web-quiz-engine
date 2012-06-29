<?php
$this->pageTitle = Yii::app ()->name;
?>

<div class="container">
<div id="content_page">
<?php 
// $content = str_replace('%THEME%', Yii::app()->theme->baseUrl, $page->content);
// echo $content;
eval($page->content);
 ?>
<!-- <p><font class="wyr"><a href="">Spróbuj już teraz!!!</a></font></p>  -->
</div>
</div>
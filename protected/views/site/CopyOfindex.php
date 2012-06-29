<?php
$this->pageTitle = Yii::app ()->name;
?>

<div class="container">
<div id="content_page">
<strong>Witaj na stronie quizu SHOP-PATRZ!</strong>

<p>Dowiesz się z niego jakim konsumentem/ką jesteś i jaki wpływ mają Twoje zakupy na świat! Znajdziesz w nim informacje o globalnych i lokalnych wyzwaniach, którym sprostać możemy świadomie dokonując wyborów konsumenckich.</p>

<p>Wszyscy uczestnicy quizu, niezależnie od uzyskanego wyniku, wezmą udział w losowaniu kosza produktów przyjaznych środowisku i pochodzących ze Sprawiedliwego Handlu.</p>

<p>Quiz powstał w ramach Tygodnia Edukacji Globalnej, który co roku organizowany jest na całym świecie w trzecim tygodniu listopada. Edukacja Globalna w swym założeniu otwiera oczy i umysły ludzi na rzeczywistość, uświadamia potrzebę stworzenia świata, w którym będzie więcej sprawiedliwości i równości oraz będą przestrzegane prawa człowieka.</p>

<p>Sponsorami produktów są:
<ul>
<li>Sklep “Natura” ul. Krupnicza 21, Kraków</li>
<li>Sklep “Dary Natury” ul. Krakowska 21, Kraków</li>
<li>Sklep ekologiczny “Pan Zielonka” ul. Dąbrówki 4/1, Kraków</li>
</ul>
</p>

<p>Zapraszamy! <br>
<img src="<?php
echo Yii::app ()->theme->baseUrl;
?>/img/loho_pah.jpg">
<br>
<a href="http://www.pah.org.pl/"><font class="wyr">Polska Akcja
Humanitarna</font></a></p>

<p><?php echo CHtml::link('Spróbuj już teraz!!!', array('question/index'))?></p>
<!-- <p><font class="wyr"><a href="">Spróbuj już teraz!!!</a></font></p>  -->
</div>
</div>
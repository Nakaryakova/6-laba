<?php
header("Content-Type: text/html; charset=utf-8"); 
session_start();
$_SESSION['test'] = md5($_SERVER['REMOTE_ADDR']);
?>
<!DOCTYPE html>
<html>
<head>	
	<title>Поликлиника</title>	
	<link rel="stylesheet" href="style.css" media="all">
</head>
<body>
	<header>
		<img src="images/headerpic.gif" alt="Картинка">
		<ul>
			<li><h1>ЛОР Клиника г. Пермь</h1>
			<li><h2>2-03-03-03</h2>
		</ul>
	</header>	
	
	<nav>
		<ul>
			<li><a href="#about">О Клинике</a></li>
			<li><a href="#lechenie">Лечение заболеваний</a></li>
			<li><a href="#entry">Записаться на прием</a></li>
			<li><a href="#contacts">Контакты</a></li>
		</ul>	
	</nav>
	
	<div id="entry"></div>
	<section>
		<h3>О Клинике</h3>
		<h4>История</h4>
		<ul>
			<li>Клиника создана в 2000 году как "Скорая ЛОР помощь".</li>
			<li>С 2007 года мы работаем в статусе специализированной ЛОР клиники.</li>
			<li>В 2016 году в сети клиник открылось новое направление - Клиника лечения кашля и аллергии.</li>
		</ul>
		<h4>Преимущества Клиники</h4>
		<ul>
			<li>Комфортные условия приема</li>
			<li>Все ЛОР-услуги - в одном месте</li>
			<li>Клиника оснащена высокотехнологичным оборудованием, одним из лучших в Перми</li>
			<li>Диагностика на уровне ЛОР-клиник Германии и Швейцарии</li>
			<li>Вся медицинская деятельность клиники лицензирована</li>
			<li>Врачи клиники постоянно изучают состояние местного и общего иммунитета у больных с патологией ЛОР-органов</li>
			<li>Врачи клиники регулярно повышают квалификацию, стажируются в российских и зарубежных клиниках и обмениваются опытом с коллегами из клиник Екатеринбурга, Москвы, Казани, Новосибирска, Мюнхена, Берна</li>
		</ul>			
	</section>
	<div id="lechenie"></div>
	<section>
		<h3>Лечение заболеваний</h3>	
		<?php
			require 'php/patient.php';
			echo Patient::get_form('php/topatient.php','php/showpatients.php','php/showlastpatient.php');
			echo $_SESSION['message'];
			$_SESSION['message'] = '';
		?>	
	</section>
	<div id="contacts"></div>
	<section>
		<h3>Контакты</h3>		
		<h4>Наш адрес</h4>
		<p>г.Пермь</p>
		<p>Бульвар Гагарина, д.101а</p>
		<p>Телефон: +7(342) 203-03-03</p>
		<h4>Режим работы</h4>
		<p>Пн-Пт: 8:00 - 20:00</p>
		<p>Сб: 9:00 - 18:00</p>
		<p>Вс: 10:00 - 17:00</p>	
	</section>
	<footer>
		<p>БУДЬТЕ ЗДОРОВЫ!</p>
	</footer>
</body>
</html>
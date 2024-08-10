 <!--
1) Установить composer https://getcomposer.org/Composer-Setup.exe
и GIT https://github.com/git-for-windows/git/releases/download/v2.46.0.windows.1/Git-2.46.0-64-bit.exe
В настройках PHP нужно включить расширения GD и ZIP (в файле c:\xampp\php\php.ini раскомментировать строки extension=gd, extension=zip)
Установить библиотеку https://github.com/claviska/SimpleImage (composer require claviska/simpleimage) и изучить ее документацию

Создать страницу с полем ввода имени пользователя github, при отправке формы скрипт должен сохранять аватар пользователя 
(https://api.github.com/users/checkuser). Все сохраненные аватары выводить таблицей, с помощью библиотеки SimpleImage 
уменьшить до размера 75х75, сделать черно-белыми, при клике должна открываться исходная версия аватара
-->
 
 <!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="utf-8" />
<title>Get Data From GitHub</title>
<link rel="stylesheet" href="main.css">
</head>
<body>
<main class="main">
  <div class="container">
    <div class="wrapper">
      <form class="form" action='index.php' method="POST" >
        <div class="form__header">
          <h1 class="form__h1">Data from GitHub</h1>
        </div>
         <div class=form__div>
            <label class="form__label">Enter Name: </label>
            <input class="form__input" type="text" name="name" />
            <button class="form__button" (click)="showData()">Search</button>
        </div>
      </form>
	 </div>
	
	<?php 
	     require __DIR__ . '/lib.php';
	    // получить данные из формы через $_POST
		// получить json с данными по ссылке и его в указанную директорию
		// получить аватор по ссылке и загрузить его в указанную директорию
		// получить из директорий json'ы и вывести в таблицу
		// предаврительно преобразовать json'ы в массив
		// вывести массив данных и фото в таблице
		if($_POST['name']){
	    $name = $_POST['name'];
		$url = "https://api.github.com/users/" . $name;
		$headers = array( 'User-Agent: x-treme-dev' ); // заголовок с логином для получения данных из GitHub
				function getRequest($url, $headers) {
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					$response = curl_exec($ch);
					curl_close($ch);
					return $response;
				}
					$response = getRequest($url, $headers);
					// преобразовать json в массив
					$array = json_decode($response, true);
					/*echo '<div>';
					print_r($array);
					echo '</div>';
					die();*/
					// запись файл аватара в директорию
					try{
						if( ! ( $ch = curl_init() ) ) 
								throw new Exception('Curl init failed');
								$options = [
									CURLOPT_URL            => $array['avatar_url'],
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_HTTPHEADER     => [
										'User-Agent' => 'x-treme-dev',
									]
								];
										
								curl_setopt_array($ch, $options);
								$file = curl_exec( $ch );
								// поместить $file (аватар) в указанную директорию на сервере
								file_put_contents( __DIR__ . '\avatar\\' . $name . '.png',  $file);
								// после того, как аватар положен в директорию avatar c новым именем,
								// взять файл из директории avatar, обработать функциями библиотеки SimpleImage
								// и положить в директорию newavatar
								getChangeImage('avatar/', $name . '.png');
					} catch(Exception $e){
						 echo $e->getMessage();
					  }
			           
				}else{
			echo 'name is not searched...enter name';
		}
		
		
		//---------------------Вывести таблицу Имя Обработка Оригинал----------------
		
		 echo '<div class="out">'; 
					   // вывести таблицу с данными из файлов, если файлы загружены в директории
					   echo '<table class="table">';
					   echo '<tr class="table__tr">';
					   echo '<th class="table__th">Login</th>';
					   echo '<th class="table__th">Processing<br></th>';
					   echo '<th class="table__th">Original</th>';
					   echo '</tr>';
					   
					     // найти картинку в другой папке
						 // использовать библиотеку SimpleImage
						
							$dir_img = __DIR__.'\newavatar\\'; // путь к каталогу c загруженными картинками 
							    if($dhi = opendir($dir_img)){
									while (($file_img = readdir($dhi)) !== false) {
							       // если название картники (name.png) соответствует текущему логину, то выводим в теге img
										 if(filetype($dir_img . $file_img) == 'file'){
											preg_match('/[a-zA-Z]+(.*?)/', $file_img, $matches);
											$name = $matches[0];
											echo '<tr class="table__tr">';
											echo '<td class="table__td">' . $name . '</td>';
											echo '<td class="table__td"  id=' . $name . '><img src="newavatar/' . $file_img . '"/></td>';
											echo '<td class="table__td" id=' . $name .'-orig' . '>' . '</td>';
											echo '</tr>';  
										    }
									 }	
							     }
						echo '</div>';			   
		
    ?>
	
  </div>
  </main>
  <script src="main.js"></script>
 </body>
</html>






 
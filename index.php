<?php
	if(isset($_GET['location'])){
		file_put_contents('coords.json', json_encode(array('location'=> $_GET['location'])));
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	else{
		if(isset($_GET['kill'])){
			exec('pkill -f example.py');
		}
		if(isset($_GET['start'])){
			$steps = '3';
			if(isset($_GET['steps'])){
				$steps = $_GET['steps'];
			}
			$host = '127.0.0.1';
			if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
				$host = '0.0.0.0';
			}
			$port = intval(file_get_contents('port.conf'));
			$command = 'example.py -u panferno44 -p hola45 -l "durango" -H '.$host.' -P '.$port.' -st '.$steps;
			if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
				$command = 'python '.$command;
			}
			setcookie("pGo", $port,  time()+600);
			$_COOKIE['pGo'] = $port;
			$port++;
			file_put_contents('port.conf', $port);
			exec($command.' > /dev/null 2>/dev/null &');
		}
		if(isset($_COOKIE['pGo'])){
			header('Location: http://'.$_SERVER['HTTP_HOST'].':'.$_COOKIE['pGo']);	
		}
		else{
			if(strpos($_SERVER['REQUEST_URI'], '?') !== false){
				header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&start');	
			}
			else{
				header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?start');	
			}
		}
	}
?>

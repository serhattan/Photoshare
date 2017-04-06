<?php
try{
	$conn = new PDO('mysql: host=localhost; dbname=photo-share; charset=utf8', 'root','');
}
catch(PDOException $e){
	echo "Veritabanı bağlantısı başarısız: " .$e ->getMessage();
}
?>
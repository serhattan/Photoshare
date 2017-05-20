<?php
try{
	$conn = new PDO('mysql: host=localhost; dbname=daybreak; charset=utf8', 'root','');
}
catch(PDOException $e){
	echo "Veritabanı bağlantısı başarısız: " .$e ->getMessage();
}
?>
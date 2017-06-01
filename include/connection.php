<?php
require_once "dbinfo.php";
try{
	$conn = new PDO('mysql: host='.hostname.'; dbname='.dbname.'; charset=utf8', user, password);
}
catch(PDOException $e){
	echo "Veritabanı bağlantısı başarısız: " .$e ->getMessage();
}
?>
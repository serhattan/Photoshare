<? require_once "include/init.php";
redirectedIfNotLoggedIn();



$sql_photos = $conn -> query("SELECT * FROM medias ORDER BY id DESC ");
$sql_photos_result= $sql_photos ->fetchAll();


include "views/home.php";
?>
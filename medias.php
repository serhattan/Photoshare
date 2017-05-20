<? require_once "include/init.php";
redirectedIfNotLoggedIn();

if (!isset($_GET['id']) || empty($_GET['id']))
	header("Location: index.php");

//we take user's user_groups_id value via url
$user_groups_id=explode('=', $_SERVER["QUERY_STRING"]);
$_SESSION['user_groups_id']=$user_groups_id[1];

//we take group id
//=18
$sql_groups = $conn -> query("SELECT user_groups.groups_id, groups.name FROM user_groups INNER JOIN groups ON user_groups.groups_id=groups.id WHERE user_groups.id=".$_GET['id']);
$sql_groups_result = $sql_groups->fetchAll();

$sql_photos = $conn -> query("SELECT medias.id, medias.user_groups_id, medias.path, medias.meta_info, medias.added_time FROM medias INNER JOIN user_groups ON user_groups.groups_id=".$sql_groups_result[0]['groups_id']." WHERE medias.user_groups_id = user_groups.id ORDER BY medias.id DESC ");
$sql_photos_result= $sql_photos ->fetchAll();

include "views/home.php";
?>
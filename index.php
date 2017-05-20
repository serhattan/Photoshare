<? require_once "include/init.php";
redirectedIfNotLoggedIn();

//kullanıcının oluşturduğu grupları getiren sorgu
$sql_createdgroups = $conn->query("SELECT user_groups.id,groups.name FROM groups INNER JOIN user_groups ON user_groups.groups_id=groups.id WHERE groups.users_id = ".$_SESSION['user_id']." AND user_groups.users_id =".$_SESSION['user_id']." ORDER BY id DESC");
$sql_createdgroups_result = $sql_createdgroups->fetchAll();

// kullanıcının üye olduğu grupları getiren sorgu
$sql_groupmember = $conn->query('SELECT user_groups.id,name FROM `user_groups` INNER JOIN groups ON groups.id=user_groups.groups_id WHERE user_groups.users_id= '.$_SESSION['user_id'].' ORDER BY user_groups.id DESC');
$sql_groupmember_result = $sql_groupmember->fetchAll();

include "views/groupspage.php"

?>
<? require_once "include/init.php";
redirectedIfNotLoggedIn();

if (!isset($_GET['id']) || empty($_GET['id']))
	header("Location: index.php");

//we take user's user_groups_id value via url
$user_groups_id=explode('=', $_SERVER["QUERY_STRING"]);  
$_SESSION['user_groups_id']=$user_groups_id[1];

//we take group id
$sql_groups = $conn -> query("SELECT user_groups.groups_id, groups.users_id, groups.name FROM user_groups INNER JOIN groups ON user_groups.groups_id=groups.id WHERE user_groups.id=".$_GET['id']);
$sql_groups_result = $sql_groups->fetchAll();

//we check the user is admin or not
if ($sql_groups_result[0]['users_id']==$_SESSION['user_id']) {
	//we take the group members
	$sql_groupMembers = $conn->query("SELECT * FROM group_members WHERE groups_id=".$sql_groups_result[0]['groups_id']);
	$sql_groupMembers_result = $sql_groupMembers->fetchAll();
}

//we take group's photos
$sql_photos = $conn -> query("SELECT medias.id, medias.user_groups_id, medias.path, medias.meta_info, medias.added_time FROM medias INNER JOIN user_groups ON user_groups.groups_id=".$sql_groups_result[0]['groups_id']." WHERE medias.user_groups_id = user_groups.id ORDER BY medias.id DESC ");
$sql_photos_result= $sql_photos ->fetchAll();

if (isset($_POST['memberMail'])) {
//We check the user is admin or not
	if ($sql_groups_result[0]['users_id']==$_SESSION['user_id']) {
		foreach ($_POST['memberMail'] as $memberMail) {
			$sql_addGroupMember = $conn->prepare("INSERT INTO group_members(groups_id,members_mail) VALUES(?, ?)");
			$isAddedGroupMember = $sql_addGroupMember->execute([$sql_groups_result[0]['groups_id'], $memberMail]); 
			if ($isAddedGroupMember) {
				Alert::addMessage("BAŞARILI: Kullanıcılar grup veritabanına başarıyla eklendi!!!");
			}else{
				Alert::addMessage("HATA: Kullanıcılar grup veritabanına eklenemedi!!!");
			}
		}
	}else{
		Alert::addMessage("HATA: Sadece grup kurucusu gruba üye ekleyebilir!!!");
	}
}

include "views/home.php";
?>
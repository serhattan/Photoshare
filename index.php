<? require_once "include/init.php";
redirectedIfNotLoggedIn();

//We take name of the group which user's create
if (isset($_POST['groupName']) && !empty($_POST['groupName'])) {
	$sql_newGroupName = $conn -> prepare("INSERT INTO groups (users_id,name) VALUES(?, ?)");
	$isAddedGroupName = $sql_newGroupName -> execute([$_SESSION['user_id'], $_POST['groupName']]);

	$last_id=$conn->lastInsertId();

	$sql_added_userGroups = $conn -> prepare("INSERT INTO user_groups (users_id, groups_id) VALUES(?, ?)");
	$isAddedUserGroups = $sql_added_userGroups -> execute([$_SESSION['user_id'], $last_id]);

	if ($isAddedGroupName && $isAddedUserGroups) {					
		Alert::addMessage($_POST['groupName'] ." isimli grup başarıyla oluşturuldu.");
	}else{					
		Alert::addMessage("HATA: grup oluşturulamadı!!!");
	}
}
if (isset($_POST['joinGroupName'])) {
	$sql_groupsName = $conn ->query("SELECT * FROM groups WHERE 1");
	$groupsName=$sql_groupsName->fetchAll();
	foreach ($groupsName as $groupinfo) {
		if ($groupinfo['name']==$_POST['joinGroupName']) {
			$sql_groupMembers = $conn->query("SELECT members_mail FROM group_members WHERE groups_id=".$groupinfo['id'])->fetchAll();
			
			//@todo kullanıcının session name bilgisi email adresi ile değiştirildiğinde buradaki sorgu kaldırılacak
			$userMail=$conn->query("SELECT email FROM users WHERE id=".$_SESSION['user_id'])->fetchAll();
			foreach ($sql_groupMembers as $groupMember) {
				if ($groupMember['members_mail']==$userMail[0]['email']) {
					$sql_added_userGroups = $conn -> prepare("INSERT INTO user_groups (users_id, groups_id) VALUES(?, ?)");
					$isAddedUserGroups = $sql_added_userGroups->execute([$_SESSION['user_id'], $groupinfo['id']]);
					if ($isAddedUserGroups) {
						header("Location: medias.php?id=".$conn->lastInsertId());
					}
				}
			}
			Alert::addMessage("HATA: Kullanıcının maili bu gruba kayıtlı değil. Lütfen Grup Başkanıyla İletişime Geçiniz!!!");
		}
	}
}

//kullanıcının oluşturduğu grupları getiren sorgu
$sql_createdgroups = $conn->query("SELECT user_groups.id,groups.name FROM groups INNER JOIN user_groups ON user_groups.groups_id=groups.id WHERE groups.users_id = ".$_SESSION['user_id']." AND user_groups.users_id =".$_SESSION['user_id']." ORDER BY id DESC");
$sql_createdgroups_result = $sql_createdgroups->fetchAll();

// kullanıcının üye olduğu grupları getiren sorgu
$sql_groupmember = $conn->query('SELECT user_groups.id,name FROM `user_groups` INNER JOIN groups ON groups.id=user_groups.groups_id WHERE user_groups.users_id= '.$_SESSION['user_id'].' ORDER BY user_groups.id DESC');
$sql_groupmember_result = $sql_groupmember->fetchAll();


include "views/groupspage.php"

?>
<?php
require_once "include/init.php";
redirectedIfNotLoggedIn();


$sql_checkAdminUser=$conn->query("SELECT groups.id,groups.users_id,groups.name FROM groups INNER JOIN user_groups ON user_groups.id=".$_SESSION["user_groups_id"]." WHERE groups.id=user_groups.groups_id")->fetchAll();

if (isset($_GET['func']) && $_GET['func']=="exitGroup") {
	if($sql_checkAdminUser[0]['users_id']==$_SESSION['user_id'])
		goto deleteGroup;
	$sql_deteGroup = $conn-> query("DELETE FROM user_groups WHERE id=".$_SESSION["user_groups_id"]);
	Alert::addMessage($sql_checkAdminUser[0]['name']." Adlı Gruptan Çıktın.");
	header("Location: index.php");
	exit();
}

	//We check the user is admin of the grup or not
if($sql_checkAdminUser[0]['users_id']==$_SESSION['user_id']){
	if (isset($_POST['selectedGroupMembers'])) {
		foreach ($_POST['selectedGroupMembers'] as $data) {
			$info=explode(",", $data);
			$sql_deleteGroupMember = $conn->query("DELETE FROM group_members WHERE id=".$info[0]);
			
			//silinen email listesini gruptan tamamen çıkartmak için bu iki sorguya ihtiyacımız var
			$sql_users_id = $conn->prepare("SELECT id FROM users WHERE email='".$info[1]."'");
			$sql_users_id->execute();
			$result=$sql_users_id->fetch();

			$sql_userGroupsGroupId = $conn->query("SELECT groups_id FROM user_groups WHERE id=".$_SESSION['user_groups_id'])->fetchAll();

			$sql_deleteUserGroups = $conn->query("DELETE FROM user_groups WHERE users_id=".$result['id']." AND groups_id=".$sql_userGroupsGroupId[0]['groups_id']);
		}
		goto jump;
	}
	if ($_GET['func']=="deleteGroup") {
		deleteGroup:
		$sql_deteGroup = $conn-> query("DELETE FROM groups WHERE id=".$sql_checkAdminUser[0]['id']);
		Alert::addMessage("Grup Başırıyla Silindi.");
		header("Location: index.php");
		exit();
	}

	$selectedPhotos=$_POST['selectedPhotos'];

	//formdan seçili fotoğraf gelip gelmediğine bakılır
	if (isset($_POST['selectedPhotos']) and count($_POST['selectedPhotos']) > 0) {

		//seçilip gönderilen her fotoğrafın veritabanından silinmesi 
		foreach ($selectedPhotos as $selectedPhoto) {
			$sql_photos_media = $conn -> query("SELECT * FROM medias WHERE id=$selectedPhoto ORDER BY id DESC");
			$sql_photos_media_delete = $conn -> query("DELETE FROM medias WHERE id = $selectedPhoto ORDER BY id DESC ");

		//deleting photos from their root folder
			foreach ($sql_photos_media as $photo) {
				unlink("photos/".$photo['path']);
				unlink("photos/thumbnails/".$photo['path']);
				unlink("photos/previews/".$photo['path']);
			}
		}
		Alert::addMessage("Silme işlemi Başırıyla gerçekleştirildi.");

	}else{
		Alert::addMessage("!!!Fotoğraf silme işlemi başarısız. Lütfen silmek için en az bir tane fotoğraf seçiniz.  ");
	}
}else{	
	Alert::addMessage("!!!Sadece Grup Admini Bu İşlemini Gerçekleştirebilir.");
}
jump:
header("Location:medias.php?id=".$_SESSION["user_groups_id"]);
include "views/footer.php"; 
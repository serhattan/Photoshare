<?php
require_once "include/init.php";
redirectedIfNotLoggedIn();

	//formdan seçili fotoğraf gelip gelmediğine bakılır
if (isset($_POST['selectedPhotos']) and count($_POST['selectedPhotos']) > 0) {
	$selectedPhotos=$_POST['selectedPhotos'];

	$sql_checkAdminUser=$conn->query("SELECT groups.users_id FROM groups INNER JOIN user_groups ON user_groups.id=".$_SESSION["user_groups_id"]." WHERE groups.id=user_groups.groups_id")->fetchAll();

	//We check the user is admin of the grup or not
	if($sql_checkAdminUser[0]['users_id']==$_SESSION['user_id']){

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
		Alert::addMessage("!!!Sadece Grup Admini Fotoğraf Silme İşlemini Gerçekleştirebilir.");
	}
}else{	
	Alert::addMessage("!!!Fotoğraf silme işlemi başarısız. Lütfen silmek için en az bir tane fotoğraf seçiniz.  ");
}

header("Location:medias.php?id=".$_SESSION["user_groups_id"]);
include "views/footer.php"; 
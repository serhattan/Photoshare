<?php
require_once "include/init.php";
redirectedIfNotLoggedIn();

	//formdan seçili fotoğraf gelip gelmediğine bakılır
if (isset($_POST['selectedPhotos']) and count($_POST['selectedPhotos']) > 0) {
	$selectedPhotos=$_POST['selectedPhotos'];

		//seçilip gönderilen her fotoğrafın veritabanından silinmesi 
	foreach ($selectedPhotos as $selectedPhoto) {

		$sql_photos_media = $conn -> query("SELECT * FROM medias WHERE id=$selectedPhoto ORDER BY id DESC");
		$sql_photos_media_delete = $conn -> query("DELETE FROM medias WHERE id = $selectedPhoto ORDER BY id DESC ");
		$sql_photos_rating_delete = $conn ->query("DELETE FROM medias WHERE media_id=$selectedPhoto ORDER BY id DESC");
		
			//fotoğrafların bulundukları yerlerden silinmesi
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

header("Location:medias.php?id=".$_SESSION["user_groups_id"]);
//include "views/footer.php"; 
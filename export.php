<?php
// Tüm fotoğrafların zip şeklinde indirilme işleminin yapıldığı yer
include_once "include/init.php";

//hangi butona tıklanıldığının kontrolünün yapalım
if (isset($_POST['downloadSelectedPhotos'])){
	//herhangi bir dosyanın seçilip seçilmediği kontrolünün yapıldığı yer
	if(isset($_POST['selectedPhotos']) and count($_POST['selectedPhotos']) > 0){
		$selectedPhotos=$_POST['selectedPhotos'];
		foreach ($selectedPhotos as $selectedPhoto) {
			$sql_photos = $conn -> query("SELECT * FROM medias WHERE id = $selectedPhoto ORDER BY id DESC ");
			$sql_photos_result= $sql_photos ->fetch(PDO::FETCH_ASSOC);
			$downloads[] = $sql_photos_result;
		}
		//zip dosyası oluşturulur
		$zipname = 'photoshare-export.zip';
		$zip = new ZipArchive;
		$zip->open($zipname, ZipArchive::CREATE);
		foreach ($downloads as $download) {
			$zip->addFile("photos/".$download['path']);
		}
		$zip->close();
		//bu talebe oluşturduğumuz dosyanın indirilmesi için yanıt verelim
		header('Content-Type: application/zip');
		header('Content-disposition: attachment; filename='.$zipname);
		header('Content-Length: ' . filesize($zipname));
		readfile($zipname);
		unlink($zipname);
	}else{
		Alert::addMessage("!!!HATA: Lütfen indirmek istediğiniz dosyayı işaretleyiniz.");
	}
}else if ($_POST['downloadAllPhotos']) {

	$sql_groups_id = $conn -> query("SELECT groups_id FROM user_groups WHERE id=".$_SESSION['user_groups_id']);
	$sql_groups_id_result = $sql_groups_id->fetchAll();

	$sql_photos = $conn -> query("SELECT * FROM medias INNER JOIN user_groups ON user_groups.groups_id=".$sql_groups_id_result[0]['groups_id']." WHERE medias.user_groups_id = user_groups.id ORDER BY medias.id DESC ");
	$sql_photos_result= $sql_photos ->fetchALL();

	if ((count($sql_photos_result)>0)) {
		$zipname = 'photoshare-export.zip';
		$zip = new ZipArchive;
		$zip->open($zipname, ZipArchive::CREATE);
		foreach($sql_photos_result as $photo) {
			$zip->addFile("photos/".$photo['path']);
		}
		$zip->close();

		header('Content-Type: application/zip');
		header('Content-disposition: attachment; filename='.$zipname);
		header('Content-Length: ' . filesize($zipname));
		readfile($zipname);
		unlink($zipname);
	}else{
		Alert::addMessage("!!!HATA: Lütfen sistemde en az 1 dosya olduğundan emin olunuz.");
	}
}
if(count($zip)== 1){
	Alert::addMessage("İndirme işlemi başarıyla gerçekleştirildi.");
}

header("Location: medias.php?id=".$_SESSION["user_groups_id"]);
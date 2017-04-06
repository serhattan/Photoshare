<?php
// Tüm fotoğrafların zip şeklinde indirilme işleminin yapıldığı yer
include_once "include/init.php";

//hangi butona tıklanıldığının kontrolünün yapalım
if (isset($_POST['download1'])){
	
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
}else if ($_POST['download2']) {

	$sql_photos = $conn -> query("SELECT * FROM medias ORDER BY id DESC ");
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
header("Location: index.php");
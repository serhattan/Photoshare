<?php
include_once "include/init.php";

//formdan photo isimli alandan dosya geldi mi bakalım
if (isset($_FILES['photos'])) {

	for ($i=0; $i < count($_FILES['photos']['name']) ; $i++) { 

 		//dosya geldiyse bir fotoğraf olduğundan emin olalım
		if (isUploadedFileAnImage($_FILES['photos']['tmp_name'][$i])) {
			//fotoğraf ise, yeni bir isim verelim, "photos/" dizinimize kaydedelim
			$imageExtention = pathinfo($_FILES['photos']['name'][$i], PATHINFO_EXTENSION);
			$originName = $_FILES['photos']['name'][$i];
			$newimagename = uniqid().$i. "." . $imageExtention ;
			$destination = "photos/" . $newimagename ;
			$isUploaded = move_uploaded_file($_FILES['photos']['tmp_name'][$i], $destination );

		//eğer kendi dizinimize kaydetme başarılı olursa yeni ismini ve bu ekleme işlemini yapan kullanıcının bilgilerini, eklenme tarihiyle birlikte veri tabanına yazalım
			if ($isUploaded) {

				$image = new \Eventviva\ImageResize($destination);
				$image 
					-> crop(300,300)
					-> save("photos/thumbnails/" . $newimagename)
					-> resizeToBestFit(1200,900)
					-> save("photos/previews/". $newimagename);

				$sql_added = $conn -> prepare("INSERT INTO medias (user_groups_id, path, added_time) VALUES (?, ?, ? )");
				//sql_added içerisindeki user_groups_id kolonuna $_SESSION['user_id'] değeri insert ediliyordu
				$isAdded = $sql_added -> execute([$_SESSION['user_groups_id'], $newimagename, date('Y-m-d H:i:s')]);

				if ($isAdded) {					
					Alert::addMessage("BAŞARILI: ". $originName ." isimli fotoğrafınız başarıyla yüklendi ve veritabanına kaydedildi.");
				}else{					
					Alert::addMessage("HATA: Fotoğrafınız yüklenemedi!!!");
				}
			}
		}else{			
			Alert::addMessage("Hata!!! Dosya yüklenemedi. ");
		}
	}
}else{	
	Alert::addMessage("Hata!!! Dosya yüklenemedi. ");
}
var_dump($_SESSION);
//

header("Location: medias.php?id=".$_SESSION["user_groups_id"]);
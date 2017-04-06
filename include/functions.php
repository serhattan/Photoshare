<?php

//giriş yapılmamışsa yönlendirme fonnksiyonu
function redirectedIfNotLoggedIn(){
	if ( ! isset($_SESSION['sessionKullaniciAdi']))
		header("Location: login.php");
}

//giriş yapılmışsa yönlendirme fonksiyonu
function redirectedIfLoggedIn(){
	if (isset($_SESSION['sessionKullaniciAdi']))
		header("Location: index.php");
}

//yüklenen dosya bir fotoğrafmı
function isUploadedFileAnImage($uploadedFileTmpName, $approvedMimeTypes = ['image/png','image/jpeg']){
	if( ! $size = getimagesize($uploadedFileTmpName)) return false;
	if(! in_array($size['mime'], $approvedMimeTypes)) return false;
	return true;
}
//dd
	function dd($any){
		?><hr><pre><?
		var_dump($any);
		?></pre><?
		die();
	}
<? require_once "include/init.php"; 

redirectedIfLoggedIn();


if (isset($_POST['kullanicininGirdigiAd']) AND $_POST['kullanicininGirdigiSifre']) {

	$sql_giris_sifresi = $conn -> prepare("SELECT * FROM login_system WHERE kullaniciadi = '".$_POST['kullanicininGirdigiAd']."'");
	$sql_giris_sifresi -> execute();

	//kullanıcının girdiği ad ile iki kişi veritabanına kayıtlıysa mysql_num_rows($sql_giris_sifresi) 1 den farklı bir değişken döneceği için else kısmı devreye giriyor burada düzenleme yaparak aynı isimli iki kullanıcının giriş yapabilmesi sağlanmalı.
	if ($sql_giris_sifresi -> rowCount() == 1){
		$row = $sql_giris_sifresi ->fetch();
	}else {
		$row = NULL;
	}
	if ( MD5($_POST['kullanicininGirdigiSifre']) == $row['kullanicisifresi']) { 
		$_SESSION['sessionKullaniciAdi'] = $_POST['kullanicininGirdigiAd'];
		$_SESSION['user_id'] = $row['id'];
		header("Location: index.php");
	}else{
		Alert::addMessage("Giriş Bilgileri Hatalı. Lütfen tekrar deneyiniz!!");
	}
}
include "views/login.php";

?>

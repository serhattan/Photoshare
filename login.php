<? require_once "include/init.php"; 

redirectedIfLoggedIn();


if (isset($_POST['username']) AND $_POST['userpassword']) {

	$sql_giris_sifresi = $conn -> prepare("SELECT * FROM users WHERE name = '".$_POST['username']."'");
	$sql_giris_sifresi -> execute();

	//kullanıcının girdiği ad ile iki kişi veritabanına kayıtlıysa mysql_num_rows($sql_giris_sifresi) 1 den farklı bir değişken döneceği için else kısmı devreye giriyor burada düzenleme yaparak aynı isimli iki kullanıcının giriş yapabilmesi sağlanmalı.
	if ($sql_giris_sifresi -> rowCount() == 1){
		$row = $sql_giris_sifresi ->fetch();
	}else {
		$row = NULL;
	}
	if ( MD5($_POST['userpassword']) == $row['password']) { 
		$_SESSION['sessionUserName'] = $_POST['username'];
		$_SESSION['user_id'] = $row['id'];
		header("Location: index.php");
	}else{
		Alert::addMessage("Giriş Bilgileri Hatalı. Lütfen tekrar deneyiniz!!");
	}
}
include "views/login.php";

?>
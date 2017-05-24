<? require_once "include/init.php"; 

redirectedIfLoggedIn();


if (isset($_POST['useremail']) AND $_POST['userpassword']) {

	$sql_giris_sifresi = $conn -> prepare("SELECT * FROM users WHERE email = '".$_POST['useremail']."'");
	$sql_giris_sifresi -> execute();

	if ($sql_giris_sifresi -> rowCount() == 1){
		$row = $sql_giris_sifresi ->fetch();
	}else {
		$row = NULL;
	}
	if ( MD5($_POST['userpassword']) == $row['password']) { 
		$_SESSION['sessionUserName'] = $row['name'];
		$_SESSION['user_id'] = $row['id'];
		header("Location: index.php");
	}else{
		Alert::addMessage("Giriş Bilgileri Hatalı. Lütfen tekrar deneyiniz!!");
	}
}
include "views/login.php";

?>
<? include "header.php"; ?>	
<link rel="stylesheet" type="text/css" href="assets/css/login.css">
</head>
<body>		
	<div class="container">
		<form class="form-signin" method="POST" action="login.php">
			<h1 class="form-signin-heading">
				<span class="daybreak">
					Daybreak
				</span>
			</h1>
			<label><i class="fa fa-user" aria-hidden="true"></i> Kullanıcı Adı: </label>
			<input type="text" name="username" placeholder="user" class="form-control" required>
			<label for="inputPassword"><i class="fa fa-key" aria-hidden="true"></i> Şifre: </label>
			<input type="password" name="userpassword" placeholder="1234" id="inputPassword" class="form-control" placeholder="" required>
			<div class="checkbox"></div>
			<button class="btn btn-lg btn-primary btn-block" type="submit" name="buttonname" style="opacity: 0.6;"><i class="fa fa-sign-in" aria-hidden="true"> Giriş Yap</i></button><br>
		</form>
		<? include "./partials/alert.php" ?>
		<? include "footer.php"; ?>
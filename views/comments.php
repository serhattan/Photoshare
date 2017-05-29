<? include "header.php";?>
</head>
<body>
	<div class="container" style="margin-top: 50px;">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="medias.php?id=<?=$_GET['ugid']?>"><i class="fa fa-camera-retro" aria-hidden="true"></i>
						Daybreak 
					</a>
				</div>
				<div class="collapse navbar-collapse" id="navbarRightSide">
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="exit.php"><i class="fa fa-sign-out" aria-hidden="true">Çıkış Yap</i></a>
						</li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="row">
			<div class="col-xs-6 col-md-6">
				<a href="#" class="thumbnail">
					<img src="<?=$_GET['pth']?>" alt="daha sonra tekrar deneyiniz">
				</a>
			</div>
			<div class="col-xs-6 col-md-6">
				<div class="fb-comments" data-href="http://localhost/daybreak/comments.php?&<?=$_GET['pth']?>&<?=$_GET['pid']?>" data-width="100%"></div>
			</div>
		</div>
	</div>

	<? include "footer.php"; ?>
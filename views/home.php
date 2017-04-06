<? include "header.php";?>
<link rel="stylesheet" type="text/css" href="assets/css/home.css">

<!-- rating sistemi ijin kullanılan ajax scripti sistem çalışıyor ise kontrollü bir şekilde footera taşı. Footerda aynı kodun olup olmadığına dikkat et-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/css/rating.css">

</head>
<body>
	<div class="container" style="margin-top: 50px;">
		<div class="container">
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
						<a class="navbar-brand" href="index.php"><i class="fa fa-camera-retro" aria-hidden="true"></i>
							Daybreak
						</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="exit.php"><i class="fa fa-sign-out" aria-hidden="true">Çıkış Yap</i></a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<h2>
				Hoşgeldin <strong><?=$_SESSION['sessionKullaniciAdi']?>!</strong><img id='loading' src='./photos/system/loader(64).gif' style='visibility: hidden;'><br>
			</h2>

			<? include "./partials/alert.php"; ?>

			<form action="upload.php" class="form-inline" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label  for="imgPhotos">Dosyalar</label>
					<input class="form-control" type="file" id="imgPhotos" name="photos[]" accept=".png, .jpg, .jpeg, image/png, image/png, image/jpeg" multiple><br>
				</div>
				<button type="submit" id="upload" class="btn btn-primary">Fotoğrafları Yükle</button>
			</form>
			<form action="export.php" id="exportId" method="post">
				<div class="row" style="margin-top:25px;">
					<div class="col-md-6"></div>
					<div class="col-md-3">
						<input type="submit" class="btn btn-default btn-block" id="selectedDownload" name="download1" onclick="history.go(0)" value="Seçtiğim Fotoğrafları İndir">
					</div>
					<div class="col-md-3">
						<input class="btn btn-default btn-block" id="allDownload" name="download2" type="submit" value="Tüm Fotoğrafları İndir">
					</div>
				</div>
				<hr>
				<div class="uploads">
					<div class="row">
						<div class="col-md-9">
							<h1 style="margin-top:0;">
								Yüklenen Fotoğraflar
							</h1>
						</div>
						<div class="col-md-3" style="float:right;" >
							<input type="checkbox" class="selectedBoxes" label="check all"/>Hepsini Seç
							<button onclick="removePage();" class="btn btn-default" id="removeButtonId" name="removeButton" style="border: none; "><i class="fa fa-trash fa-2x" aria-hidden="true" style="color:#cc0000;"></i></button>
						</div>
					</div>
					<div class="row">
						<?foreach($sql_photos_result as $photo):
						$photoid = intval($photo['id']);
						$result =$conn -> query("SELECT rating_number, FORMAT((total_points / rating_number),1) as rating_average FROM rating_system WHERE media_id = $photoid AND status = 1");
						$ratingRow = $result->fetch(PDO::FETCH_ASSOC);
						$average_sort_array[]=array("average" => $ratingRow['rating_average'], "id" => $photo['id']);
						rsort($average_sort_array);
						?>
						<div class="col-md-2">
							<input type="checkbox" class="checkboxes"	name="selectedPhotos[]" value="<?=$photo['id']?>" style="width: 20px; height: 20px;">
							<a class="fancybox fancybox-button" rel="group" href="<?="photos/previews/".$photo['path'];?>">
								<img src="<?="photos/thumbnails/".$photo['path'];?>" class="img-thumbnail main-img" rel="group">
							</a>
							<input name="rating" value="0" id="rating_star" type="hidden" postID="<?=$photo['id']; ?>" />
							<ul class="codexworld_rating_widget">
								<li style="background-image: url('./photos/system/star_highlight.png'); background-position: 0px 0px;"></li>
								<li style="background-image: url('./photos/system/star_highlight.png'); background-position: 0px 0px;"></li>
								<li style="background-image: url('./photos/system/star_highlight.png'); background-position: 0px 0px;"></li>
								<li style="background-image: url('./photos/system/star_highlight.png'); background-position: 0px 0px;"></li>
							</ul>
							<div style="clear:both;"></div>
							<div class="overall-rating">
								Kullanılan oy: <span id="totalrat"><?php echo $ratingRow['rating_number'];?></span><br>Ortalama puan: <span id="avgrat"><?php echo $ratingRow['rating_average']; ?></span>
							</div>
						</div><? endforeach; ?>
					</div>
					<br>
					<div><h3 style="margin-top:35;">Sıralanmış Fotoğraflar</h3></div>
					<div class="row">
						<?
						//sıralanmış fotoğraflar
						if (isset($average_sort_array)) {
							foreach($average_sort_array as $sorted):
								$sortedId = intval($sorted['id']);
							$result =$conn -> query("SELECT * FROM medias WHERE id = $sortedId");
							$denemeRow = $result->fetch(PDO::FETCH_ASSOC);
							?>
							<div class="col-md-2">
								<input type="checkbox" class="checkboxes"	name="selectedPhotos[]" value="<?=$sorted['id']?>" style="width: 20px; height: 20px;">
								<a class="fancybox fancybox-button" rel="group" href="<?="photos/previews/".$denemeRow['path'];?>">
									<img src="<?="photos/thumbnails/".$denemeRow['path'];?>" class="img-thumbnail main-img" rel="group">
								</a>
							</div>
							<?endforeach; }?>
						</div>
					</div>
				</form>
			</div>
		</div>
		<? include "footer.php"; ?>
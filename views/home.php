<? include "header.php";?>
<link rel="stylesheet" type="text/css" href="assets/css/home.css">

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
					<a class="navbar-brand" href="index.php"><i class="fa fa-camera-retro" aria-hidden="true"></i>
						Daybreak
					</a>
				</div>
				<div class="collapse navbar-collapse" id="navbarRightSide">
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="#" onclick="showGroupMember()" id="showGroupMember" style="display: none;"><i class="fa fa-list-ul" aria-hidden="true"></i> Grup Üyelerini Listele </a>
						</li>
						<li>
							<a href="#" onclick="showForm()" id="addingGroupMember" style="display: none;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Grup Üyesi Ekle </a>
						</li>
						<li>
							<a href="remove.php?func=deleteGroup" id="deleteGroup" onclick="return confirm('<?=$sql_groups_result[0]['name']?> Grubunu Gerçekten Silmek İstiyor musunuz?');" style="display: none;"><i class="fa fa-trash fa-x" aria-hidden="true"></i> Grubu Sil</a>
						</li>
						<li>
							<a href="remove.php?func=exitGroup" <?if ($sql_groups_result[0]['users_id']==$_SESSION['user_id']){?>onclick="return confirm('<?=$sql_groups_result[0]['name']?> Grubundan Çıkmak Ve Grubu Tamamen Silmek İstiyor musunuz?');"<?}else{?>onclick="return confirm('<?=$sql_groups_result[0]['name']?> Grubundan Çıkmak İstiyor musunuz?');"<?}?>><i class="fa fa-times-circle" aria-hidden="true"></i> Gruptan Çık</a>
						</li>
						<li>
							<a href="exit.php"><i class="fa fa-sign-out" aria-hidden="true">Çıkış Yap</i></a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<h1 style="text-align: center">
			Hoşgeldin <strong><?=$_SESSION['sessionUserName']?>!</strong><img id='loading' src='./photos/system/loader(64).gif' style='visibility: hidden;'><br>
		</h1>
		<form action="remove.php" method="POST">
			<div id="groupMembersList" style="display:none;">
				<h3>Grup Üyeleri</h3>
				<?foreach ($sql_groupMembers_result as $groupMember):?>
				<div class="row">
					<input type="checkbox" name="selectedGroupMembers[]" value="<?=$groupMember['id'];?>,<?=$groupMember['members_mail'];?>" style="width: 20px; height: 20px;"/> 
					<span><?=$groupMember['members_mail'];?></span>
				</div>
				<?endforeach;?>
				<button type="submit" class="btn btn-info" style="margin:15px 0px;">Sil</button>
			</div>
		</form>
		<form action="medias.php?id=<?=$_GET['id'];?>" method="post" class="form-horizontal">
			<div id="showHideDiv" style="display:none;">
				<div class="row" id="container1">
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label" for="formGroupInputLarge">Email Adresi</label>
						<div class="col-sm-8">
							<input name="memberMail[]" class="form-control" type="email" placeholder="daybreak@hotmail.com" required>
						</div>
						<button class="btn btn-primary addField">Yeni Bir Alan Ekle</button>
					</div>
				</div>
				<div class="col-md-12">
					<button type="submit" class="btn btn-info btn-lg" style="margin-left: 35%;margin-bottom: 50px;">Kaydet</button>
				</div>
			</div>
		</form>

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
					<input type="submit" class="btn btn-default btn-block" id="selectedDownload" name="downloadSelectedPhotos" onclick="history.go(0)" value="Seçtiğim Fotoğrafları İndir">
				</div>
				<div class="col-md-3">
					<input type="submit" class="btn btn-default btn-block" id="allDownload" name="downloadAllPhotos" value="Tüm Fotoğrafları İndir">
				</div>
			</div>
			<hr>
			<div class="uploads">
				<div class="row">
					<div class="col-md-9">
						<h1 style="margin-top:0;">
							<?=$sql_groups_result[0]['name']?>
						</h1>
					</div>
					<div class="col-md-3" style="float:right;" >
						<input type="checkbox" class="selectedBoxes" label="check all">Hepsini Seç
						<button onclick="removePage();" class="btn btn-default" id="removeFotoButtonId" name="removeButton" style="border: transparent; display:none;"><i class="fa fa-trash fa-2x" aria-hidden="true" style="color:#cc0000;"></i></button>
					</div>
				</div>
				<div class="row">
					<?foreach($sql_photos_result as $photo): ?> 
					<div class="col-md-2">
						<input type="checkbox" class="checkboxes"	name="selectedPhotos[]" value="<?=$photo['id']?>" style="width: 20px; height: 20px;">
						<a class="fancybox fancybox-button" rel="group" href="<?="photos/previews/".$photo['path'];?>">
							<img src="<?="photos/thumbnails/".$photo['path'];?>" class="img-thumbnail main-img" rel="group">
						</a>
					</div>
				<? endforeach; ?> 
			</div>
		</div>
	</form>
</div>
<? include "footer.php"; ?>
<? include "header.php";?>

<div class="container" style="margin-top: 50px;">
	<nav class="navbar navbar-default">
		<div class="container-fluid">
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
						<a href="#" onclick="showNewGroup()"><i class="fa fa-plus-circle" aria-hidden="true"></i>
							Yeni Grup Oluştur
						</a>
					</li>
					<li>
						<a href="#" onclick="showJoinNewGroup()"><i class="fa fa-sign-in" aria-hidden="true"></i>
							Yeni Bir Gruba Katıl
						</a>
					</li>
					<li>
						<a href="exit.php"><i class="fa fa-sign-out" aria-hidden="true">Çıkış Yap</i></a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<h1 style="text-align: center;">
		Hoşgeldin <strong><?=$_SESSION['sessionUserName']?>!</strong>
	</h1>
	<form action="index.php" method="post" class="form-horizontal">
		<div class="row">
			<div class="form-group form-group-lg" id="createGroup" style="display: none;">
				<label class="col-sm-2 control-label" for="formGroupInputLarge">Grup Adı</label>
				<div class="col-sm-8">
					<input name="groupName" class="form-control" type="text" id="formGroupInputLarge" placeholder="Yeni Grup Adı Giriniz" required>
				</div>
				<button type="submit" class="btn btn-default btn-lg">Kaydet</button>
			</div>
		</div>
	</form>
	<form action="index.php" method="post" class="form-horizontal">
		<div class="row">
			<div class="form-group form-group-lg" id="joinGroup" style="display: none;">
				<label class="col-sm-2 control-label" for="formGroupInputLarge">Katılmak İstediğiniz Grubun Adını Girin</label>
				<div class="col-sm-8">
					<input name="joinGroupName" class="form-control" type="text" id="formGroupInputLarge" placeholder="Lütfen Grup adını eksiksiz bir şekilde giriniz" required>
				</div>
				<button type="submit" class="btn btn-default btn-lg">Kaydet</button>
			</div>
		</div>
	</form>
	<? include "./partials/alert.php"; ?>
	<div class="row">
		<div class="col-md-6">
			<h3>Üye Olduğun Gruplar</h3>
			<ul class="nav nav-pills nav-stacked">
				<? foreach ($sql_groupmember_result as $groupMember):?>
				<li role="presentation" class="active"><a href="medias.php?id=<?=$groupMember['id']?>"> <?=$groupMember['name'];?></a></li>
				<?endforeach;?>
			</ul>
		</div>
		<div class="col-md-6">
			<h3>Oluşturduğun Gruplar</h3>
			<ul class="nav nav-pills nav-stacked">
				<? foreach ($sql_createdgroups_result as $createdGroups):?>
				<li role="presentation" class="active"><a href="medias.php?id=<?=$createdGroups['id']?>"> <?=$createdGroups['name'];?></a></li>
				<?endforeach;?>
			</ul>
		</div>
	</div>
</div>
<? include "footer.php"; ?>
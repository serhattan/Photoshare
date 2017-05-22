	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/rating.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script type="text/javascript" src="assets/source/jquery.fancybox.pack.js?v=2.1.5"></script>
	<script type="text/javascript" src="assets/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
	<script type="text/javascript" src="assets/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
	<script type="text/javascript">
		<?if ($sql_groups_result[0]['users_id']==$_SESSION['user_id']):?>
		document.getElementById('addingGroupMember').style.display="block";
		document.getElementById('removeButtonId').style.display="inline"
		<?endif;?>
	</script>
	<script type="text/javascript">


		//create new group show form script
		function showNewGroup(){
			document.getElementById('createGroup').style.display="block";
		}
		//Join new group show form script
		function showJoinNewGroup(){
			document.getElementById('joinGroup').style.display="block";
		}
		//add new member show form script
		function showForm(){
			document.getElementById('showHideDiv').style.display="block";
		}
		//add new member input area script
		$(document).ready(function() {
			var max_fields      = 10;
			var wrapper         = $("#container1"); 
			var add_button      = $(".addField"); 

			var x = 1; 
			$(add_button).click(function(e){ 
				e.preventDefault();
				if(x < max_fields){ 
					x++; 
            $(wrapper).append('<div style="margin-bottom:5px;"><label class="col-sm-2 control-label" for="formGroupInputLarge">Email Adresi</label><div class="col-sm-8"><input name="memberMail[]" class="form-control" type="email" placeholder="daybreak@hotmail.com" required="required"></div><button href="#" class="btn btn-danger delete">Delete</button></div>'); //add input box
        }
        else
        {
        	alert('Aynı anda maksimum 10 kullanıcı girebilirsiniz.')
        }
    });

			$(wrapper).on("click",".delete", function(e){ 
				e.preventDefault(); $(this).parent('div').remove(); x--;
			})
		});

		$(document).ready(function() {	
			$(".fancybox").fancybox();
			$(".fancybox-button").fancybox({
				prevEffect		: 'none',
				nextEffect		: 'none',
				closeBtn		: false,
				helpers		: {
					title	: { type : 'inside' },
					buttons	: {}
				}
			});
		});		
		function removePage() {
			form=document.getElementById('exportId');
			form.action='remove.php';
			form.submit();
		}

		//Loading gifi için kullanılan fonksiyonlar
		function showLoading(){
			document.getElementById("loading").style = "visibility: visible";
		}
		function hideLoading(){
			document.getElementById("loading").style = "visibility: hidden";
		}

		//resimleri yükleme butonu için gifin kodu
		$("#upload").click(function () {     
			showLoading();
			$.ajax({
				type: "POST",
				url: "upload.php",
				enctype: 'multipart/form-data',
				data: {
					file: myfile
				},
				success: function () {
					hideLoading();
				},
				error  : function (a) {
        //Hata oluşursa
        hideLoading();
    }
});
		});
		//Seçilenleri indir butonu için gifin kodu
		$("#selectedDownload").click(function () {     
			showLoading();
			$.ajax({
				type: "POST",
				url: "index.php",
				success: function () {
					hideLoading();
				},
				error  : function (a) {
        //Hata oluşursa
        hideLoading();
    }
});
		});
	//tüm resimleri indir butonu için gifin kodu
	$("#allDownload").click(function () {     
		showLoading();
		$.ajax({
			type: "POST",
			url: "index.php",
			success: function () {
				hideLoading();
			},
			error  : function (a) {
				hideLoading();
			}
		});
	});
		//resimleri kaldırma butonu için gifin kodu
		$("#removeButtonId").click(function () {     
			showLoading();
			$.ajax({
				type: "POST",
				url: "index.php",
				success: function () {
					hideLoading();
				},
				error  : function (a) {
					hideLoading();
				}
			});
		});

		//Tüm resimlerin seçilmesi ve kaldırılması için kullanılan kod
		$(function() {
			$('.selectedBoxes').click(function() {
				$('.checkboxes').prop('checked', this.checked);
			});
		});

	</script>
</body>
</html>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/rating.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script type="text/javascript" src="assets/source/jquery.fancybox.pack.js?v=2.1.5"></script>
	<script type="text/javascript" src="assets/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
	<script type="text/javascript" src="assets/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
	<script type="text/javascript">
		$(document).ready(function() {	
			/*
		startLength: kaç tane yıldız görüntülenmek isteniyor
		inirialValue: rating değeri sayfa ilk yüklendiğinde kaç olacak (default olarak 0)
		callbackFunctionName: yıldızlara tıklandığında çağrılmak istenen fonksiyonun yazıldığı yer
		imageDirectory: yıldız resminin directory sidir.
		inputAttr: rating değerini callbackFunction a geçirir.
		*/
		$("#rating_star").codexworld_rating_widget({
			starLength: '4',
			initialValue: '',
			callbackFunctionName: 'processRating',
			imageDirectory: './photos/system/star_highlight.png',
			inputAttr: 'postID'
		});

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


		// rating değer ajax ile gönderilir
		function processRating(val, attrVal){
			$.ajax({
				type: 'POST',
				url:'rating.php',
				data: 'postID='+attrVal+'&ratingPoints='+val,
				dataType: 'json',
				success : function(data) {
					if (data.status == 'ok') {
						$('#avgrat').text(data.rating_average);
						$('#totalrat').text(data.rating_number);
					}else{
						alert('Bir hata oluştu. Daha sonra tekrar deneyiniz.');
					}
				}
			});
		}
	</script>

</body>
</html>
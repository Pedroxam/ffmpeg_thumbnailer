<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>FFmpeg Video Thumbnailer By Pedram</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="Description" lang="en" content="ADD SITE DESCRIPTION">
		<meta name="author" content="ponishweb.ir">
		<meta name="robots" content="index, follow">
		<!-- icons -->
		<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
		<link rel="shortcut icon" href="favicon.ico">
		<!-- Bootstrap Core CSS file -->
		<link rel="stylesheet" href="./bootstrap.min.css">
		<!-- Conditional comment containing JS files for IE6 - 8 -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		<!-- JQuery scripts -->
	    <script src="./jquery.min.js"></script>
		<style>.hidden {display:none;} .mw50 {max-width:100%;}</style>
	</head>
	<body style="">

		<!-- Page Content -->
		<div class="container">
			<div class="row" style="border:1px solid #CCC; padding:30px;">
				<div class="col-sm-12">
				
					<h4 class="text-center">An Easy Way to Make Tile Video Screenshot With Ajax</h4>
					<h4 class="text-danger">By Pedram - Amoo Pedram</h4>
					
					<hr/>
					
					<div id="fileStep" class="">
						<h5>Select Video File</h5>
						<input type="file" class="btn btn-info" id="file" name="file">
					</div>
					
					
						<br/>
						
						
					<div id="secondStep" class="hidden">
						
						<input type="hidden" id="video" value=""> <!--Uploaded Video Path-->
						
						
					<div class="form-group">
					
						<h5>Set Number Of Tiles</h5>
						
						<div class="row">
						
							<div class="col-md-5">
								<input type="number" id="tile_1" class="form-control" placeholder="2" value="2">
							</div>
							
							<div class="col-md-1 text-center">
							<h5> ==> </h5>
							</div>
							
							<div class="col-md-5">
								<input type="number" id="tile_2" class="form-control" placeholder="3" value="3">
							</div>
							
						</div>
						
					</div>
						
					<div class="form-group">
					
						<h5>Set Each Capture Size</h5>
						
						<div class="row">
						
							<div class="col-md-5">
								<input type="number" id="size_1" class="form-control" placeholder="320" value="320">
							</div>
							
							<div class="col-md-1 text-center">
							<h5> ==> </h5>
							</div>
							
							<div class="col-md-5">
								<input type="number" id="size_2" class="form-control" placeholder="240" value="240">
							</div>
							
						</div>
						
					</div>
					
					
					
					
					<br/>
						
					<div class="col-md-12 text-center">
						
						<input onclick="generateThumbnail();" id="submit" class="btn btn-danger" value="Generate Thumbnail">
						
					</div>
					
					</div> <!--#hidden-->
							
					<div class="col-md-12 text-center">
					<br/><br/>
						<div id="result" class="text-center"></div>
					</div>
					

				</div>
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
		
		<script>
			//Ajax Script
			
			$(document).ready(function(){
				$("#file").change(function() {
					
					if ($(this).val() != '')
					{
						uploadFile(this); //Upload File
					}
					
				});
			});

			//Upload VIDEO
			function uploadFile(file) {
				var form_data = new FormData();
				form_data.append('file', file.files[0]);
				$.ajax({
					url: './upload.php',
					data: form_data,
					type: 'POST',
					contentType: false,
					processData: false,
					dataType: 'json',
					xhr: function() {
							var myXhr = $.ajaxSettings.xhr();
							if(myXhr.upload){
								myXhr.upload.addEventListener('progress',progress, false);
							}
							return myXhr;
				   },
					success:function (data) {
						if(data.status == true) {
							$('#result').html('Video Succesfully Uploaded !');
							
							$('#fileStep').addClass('hidden');
							$('#secondStep').removeClass('hidden');
							
							$('#video').val(data.file);
						}
						else {
							$('#result').html(data.status);
						}
						
					},
				});
			};
			
	
			// Simple Upload Proress Bar
			function progress(e){
				if(e.lengthComputable){
					var percentage = (e.loaded / e.total) * 100;
					$('#result').html('Please Wait... / ' + percentage.toFixed(0) + '%');
				}
			};
			
	
			// Generate Thumbnail
			function generateThumbnail(){
				
				$('#result').html('Generating Thumbnail, Please Wait...');
				
				$.ajax({
						url: './thumbnail.php',
						type: 'POST',
						data: { 
							video: $('#video').val(),
							tile_1:  $('#tile_1').val(),
							tile_2:  $('#tile_2').val(),
							size_1:  $('#size_1').val(),
							size_2:  $('#size_2').val(),
						},
						dataType: 'json',
					success:function (data)
					{
						if(data.status == true) {
							$('#result').html('<a target="_blank" href="' + data.image +'"><img src="' + data.image +'" class="img-fluid mw50"></a>');
						}
						else {
							$('#result').html(data.status);
						}
					},
				});
				
			};
			
			

		</script>
  </body>
</html>


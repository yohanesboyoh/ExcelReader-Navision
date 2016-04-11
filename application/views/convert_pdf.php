<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="yohanesboyoh">
	<title>Excelreader - Convert-PDF</title>

	<link href="<?=base_url()?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?=base_url()?>css/excelreader.css" rel="stylesheet">
</head>

<body>

	<header class = "container">
		<!-- <img src="<?=base_url()?>img/logo-simpatindo.png" alt="Smiley face" height="50px" width="180px" style = "color:white; margin-left : 1.5%;"> -->
		<nav>
			<ul>
				<a href = "home" > <img src="<?=base_url()?>img/logo-simpatindo.png" alt="Smiley face" height="50px" width="210px" style = "color:white; margin-left : 20px; margin-right : 20px;"> </a>
				<li> <a href = "home" >Home</a> </li>
				<li> <a href = "convert-pdf" >Convert from PDF</a> </li>
				<!-- <li> <a href = "convert-excel" >Convert from Excel</a> </li> -->
			</ul>
		</nav>
	</header>

	<main class = "container">
		<section class = "row text-center">
			<!-- <h1 id = "title-page">Convert PDF</h1> -->
		</section>
		<section id = "sec_form_convert" class = "row col-xs-10 col-sm-10 col-md-6 col-lg-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3 col-lg-offset-3">
			
			<!-- <form name = "convert_pdf" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="do-convert-pdf"> -->
			
			<?php echo form_open_multipart('do-convert-pdf');?>		


				<fieldset class = "fieldset_custom">
                    <legend class = "fieldset_custom"><div class = "text-center">Convert From PDF</div></legend>

                    <div id = "show_error" role="alert">
						<?php echo $error;?>
                    </div>

                    <div id = "upload_button" class = "row input-group col-xs-1 col-sm-1 col-md-1 col-lg-1">
                		<div class="btn btn-default btn-file">
					    	Choose File . . .<input id = "file_upload" name="file_upload" type = "file" size = "20">
					    </div>
					    <div class="input-group-addon" id="upload_information">
					    </div>
					</div>

					<div id = "type_convert" class = "row input-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<span class="input-group-addon" id="basic-addon1">Type File to Convert</span>
  						<select class="form-control" id="type_file_to_convert" name="type_file_to_convert">
							<option>Excel</option>
							<option>Word</option>
						</select>
                    </div>

                    <div id = "submit_button" class = "row text-right">
                    	<button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </fieldset>



			</form>

		</section>




		<section class = "row col-xs-10 col-sm-10 col-md-6 col-lg-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3 col-lg-offset-3">
			<!-- asdlkaskdj -->
		</section>
	</main>

	<footer class = "container">
		<?php $this->load->view('include/footer'); ?>
	</footer>



<script type="text/javascript" src="<?=base_url()?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/bootstrap.min.js"></script>


<script>
	$('#upload_button').on('change', '.btn-file :file', function() {
	    var input = $(this),
	        numFiles = input.get(0).files ? input.get(0).files.length : 1,
	        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	    input.trigger('fileselect', [numFiles, label]);
	});
    $('#upload_button .btn-file :file').on('fileselect', function(event, numFiles, label) {
    	$("#upload_information").html(label);
    });


    // nampilin error
    var error = $('#show_error p').html();
    if(error != '' && error != null){
    	$("#show_error").addClass("alert alert-danger");
    }

</script>

</body>


</hmtl>
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

	<div class = "wrapper">
		<header class = "container">
			<?php $this->load->view('include/navigation'); ?>
		</header>

		<main class = "container">
			<section class = "row text-center">
				<!-- <h1 id = "title-page">Convert PDF</h1> -->
			</section>

			<?php 
			if($table_data) {
			?>
			<section class = "row text-left">

				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class = "text-center" style = "vertical-align : middle">No</th>
							<th class = "text-center" style = "vertical-align : middle">New Name Store</th>
							<th class = "text-center" style = "vertical-align : middle">Tanggal Order</th>
							<th class = "text-center" style = "vertical-align : middle">No.Order</th>
							<th class = "text-center" style = "vertical-align : middle">CDT</th>
							<th class = "text-center" style = "vertical-align : middle">PI</th>
							<th class = "text-center" style = "vertical-align : middle">Tax 10%</th>
							<th class = "text-center" style = "vertical-align : middle">PI+Tax 10%</th>
							<th class = "text-center" style = "vertical-align : middle">So</th>
							<th class = "text-center" style = "vertical-align : middle">Selisih</th>
							<th class = "text-center" style = "vertical-align : middle">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php

						foreach ($table_data as $key_table_data => $value_table_data) {
						?>
						<tr>
							<?php
							foreach ($value_table_data as $key => $value) {
							?>
							<td class = "key_<?php echo $key; ?>"><?php echo $value; ?></td>
							<?php
							}
							?>
							<td>
								<button type="button" class="btn btn-primary btn-sm button_delete_js">
									Delete
								</button>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>

				<button type="button" class="btn btn-primary btn-sm button_download_js">
					Download
				</button>

			</section>


			<?php
			}
			?>

			<section id = "sec_form_convert" class = "row col-xs-10 col-sm-10 col-md-6 col-lg-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3 col-lg-offset-3">
				<!-- <form name = "convert_pdf" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="do-convert-pdf"> -->
				<?php echo form_open_multipart('do-otomate-excel');?>		
					<fieldset class = "fieldset_custom">
	                    <legend class = "fieldset_custom"><div class = "text-center">Otomate Excel</div></legend>

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
								<!-- <option>Word</option> -->
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


	</div>
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

    // DELETE
    $(".button_delete_js").click(function() {
        var td_cdt = $(this).closest("tr").find(".key_4").text();
        var r = confirm("Apakah anda yakin untuk menghapus data : "+td_cdt);
        if (r == true) {
        	// HAPUS JS TO SERVER
            var form = document.createElement("form");
            form.method = 'post';
            form.action = 'do-delete-otomate-excel';
            var input = document.createElement('input');
            input.type = "text";
            input.name = "data";
            input.value = td_cdt;
            form.appendChild(input);
            form.submit();
        }
    });

    // DOWNLOAD
    // DELETE
    $(".button_download_js").click(function() {
        var action = "do-download-otomate-excel";
        $(location).attr('href', action);
    });

</script>

</body>


</hmtl>
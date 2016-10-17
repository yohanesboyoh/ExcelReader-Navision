<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="yohanesboyoh">
	<title>Excelreader - Admin</title>

	<link href="<?=base_url()?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?=base_url()?>css/excelreader.css" rel="stylesheet">
</head>
<body>
	<div class = "wrapper">
		<header class = "container">
			<?php $this->load->view('include/navigation'); ?>
		</header>
		<main class = "container">
			<!-- MAIN TABLE -->
			<section>
				<div class="table-responsive">
									<button type="button" class="btn btn-primary btn-sm button_add pull-right" data-toggle="modal" data-target="#add-modal" >
										Insert
									</button>
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class = "text-center" style = "vertical-align : middle">Number</th>
								<th class = "text-center" style = "vertical-align : middle">Barcode</th>
								<th class = "text-center" style = "vertical-align : middle">Nama Barang</th>
								<th class = "text-center" style = "vertical-align : middle">Kode Barang</th>
								<th class = "text-center" style = "vertical-align : middle">Nama Barang (DRP)</th>
								<th class = "text-center" style = "vertical-align : middle">New Price</th>
								<th class = "text-center" style = "vertical-align : middle" colspan = "2">Action</th>
							</tr>
						</thead>
				    	<tbody>
				    		<?php 
							$row=0;
				    		foreach($informasi_db_excel as $key_db_excel => $value_db_excel) {
								$row+=1;
				    		?>
							<tr id = "tr-id-<?echo $key_db_excel;?>">
								<td class = "data_row"><?php echo $key_db_excel+1;?></td>
								<td class = "data_barcode"><?php echo $value_db_excel['barcode'];?></td>
								<td class = "data_namabarang"><?php echo $value_db_excel['namabarang'];?></td>
								<td class = "data_kodebarang"><?php echo $value_db_excel['kodebarang'];?></td>
								<td class = "data_namabarangdrp"><?php echo $value_db_excel['namabarangdrp'];?></td>
								<td class = "data_newprice"><?php echo $value_db_excel['newprice'];?></td>
								<td>
									<button type="button" class="btn btn-primary btn-sm button_edit" data-toggle="modal" data-target="#edit-modal">
										Update
									</button>
								</td>
								<td>
									<button type="button" class="btn btn-primary btn-sm button_delete" data-toggle="modal" data-target="#delete-modal">
										Delete
									</button>
								</td>
							</tr>
							<?php
							}
							?>
						</tbody>
				  	</table>
				</div>
			</section>
			
			<!-- INSERT MASTER BARANG -->
			<section>
                <!-- ADD FORM -->
                <div id="add-modal" class="modal fade" tabindex="1" aria-labelledby="add-modal" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Insert Master Form</h4>
							</div>
							
                            <div class="modal-body">
                            	<div class  = "container">
	                            	<form id = "insert-form" class="form-horizontal" role="form" name = "insert-form" method="POST" action="InsertExcel">
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Row</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" type="text" class="form-control" value="<?php echo $row+1?>" id="insert-row" name="insert-row"  readonly>
										</div>
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Barcode</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" required type="text" class="form-control" id="insert-barcode" name="insert-barcode" >
										</div>
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Nama Barang</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" required type="text" class="form-control" id="insert-namabarang" name="insert-namabarang">
										</div>
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Kode Barang</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" required type="text" class="form-control" id="insert-kodebarang" name="insert-kodebarang">
										</div>
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Nama Barang (DRP)</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" required type="text" class="form-control" id="insert-namabarangdrp" name="insert-namabarangdrp">
										</div>
										<div class="form-group row">
											<label class = "col-lg-3" for="email">New Price</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" required type="number" lang="sg" class="form-control" id="insert-newprice" name="insert-newprice">
										</div>
										<div class="form-group row">
											<div class = "col-lg-12">
												<input class = "btn btn-primary pull-right" type="submit" value="Submit">
											</div>
										</div>
	                            	</form>
	                            </div>
                            </div>

						</div>
					</div>
				</div>
			</section>

			<!-- EDIT MASTER BARANG -->
			<section>
                <!-- EDIT FORM -->
                <div id="edit-modal" class="modal fade" tabindex="1" aria-labelledby="edit-modal" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Edit Master Form</h4>
							</div>

                            <div class="modal-body">
                            	<div class  = "container">
	                            	<form id = "edit-form" class="form-horizontal" role="form" name = "edit-form" method="post" action="UpdateExcel">
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Row</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" required type="text" class="form-control" id="edit-row" name="edit-row" readonly>
										</div>
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Barcode</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" required type="text" class="form-control" id="edit-barcode" name="edit-barcode">
										</div>
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Nama Barang</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" required type="text" class="form-control" id="edit-namabarang" name="edit-namabarang">
										</div>
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Kode Barang</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" required type="text" class="form-control" id="edit-kodebarang" name="edit-kodebarang">
										</div>
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Nama Barang (DRP)</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" required type="text" class="form-control" id="edit-namabarangdrp" name="edit-namabarangdrp">
										</div>
										<div class="form-group row">
											<label class = "col-lg-3" for="email">New Price</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" required type="number" class="form-control" id="edit-newprice" name="edit-newprice">
										</div>
										<div class="form-group row">
											<div class = "col-lg-12">
												<input class = "btn btn-primary pull-right" type="submit" value="Submit">
											</div>
										</div>
	                            	</form>
	                            </div>
                            </div>
						</div>
					</div>
				</div>

			</section>
			
						<!-- DELETE MASTER BARANG -->
			<section>
                <!-- DELETE FORM -->
                <div id="delete-modal" class="modal fade" tabindex="1" aria-labelledby="delete-modal" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Delete Master Form</h4>
							</div>
							
                            <div class="modal-body">
                            	<div class  = "container">
	                            	<form id = "delete-form" class="form-horizontal" role="form" name = "delete-form" method="POST" action="DeleteExcel">
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Row</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" type="text" class="form-control" id="delete-row" name="delete-row" readonly>
										</div>
										
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Barcode</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" type="text" class="form-control" id="delete-barcode" name="delete-barcode" readonly>
										</div>
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Nama Barang</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" type="text" class="form-control" id="delete-namabarang" name="delete-namabarang" readonly>
										</div>
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Kode Barang</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" type="text" class="form-control" id="delete-kodebarang" name="delete-kodebarang" readonly>
										</div>
										<div class="form-group row">
											<label class = "col-lg-3" for="email">Nama Barang (DRP)</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" type="text" class="form-control" id="delete-namabarangdrp" name="delete-namabarangdrp" readonly>
										</div>
										<div class="form-group row">
											<label class = "col-lg-3" for="email">New Price</label>
											<label class = "col-lg-1">:</label>
											<input class = "col-lg-8" type="number" class="form-control" id="delete-newprice" name="delete-newprice" readonly>
										</div>
										<div class="form-group row">
											<div class = "col-lg-12">
												<input class = "btn btn-primary pull-right" type="submit" value="Submit">
											</div>
										</div>
	                            	</form>
	                            </div>
                            </div>

						</div>
					</div>
				</div>
			</section>
			
		</main>
	</div>
	<footer class = "container">
		<?php $this->load->view('include/footer'); ?>		
	</footer>
	<script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
		
	    // BUTTON EDIT
	    $('.button_edit').click(function (e) {
	        e.preventDefault();
    	    // GET DATA
			var data_row = $(this).closest("tr").find(".data_row").text();
    	    var data_barcode = $(this).closest("tr").find(".data_barcode").text();
    	    var data_namabarang = $(this).closest("tr").find(".data_namabarang").text();
    	    var data_kodebarang = $(this).closest("tr").find(".data_kodebarang").text();
    	    var data_namabarangdrp = $(this).closest("tr").find(".data_namabarangdrp").text();
    	    var data_newprice = $(this).closest("tr").find(".data_newprice").text();
	    	
	    	// SET DATA TO EDIT MASTER FORM
			$('#edit-modal #edit-row').val(data_row);
	    	$('#edit-modal #edit-barcode').val(data_barcode);
	    	$('#edit-modal #edit-namabarang').val(data_namabarang);
	    	$('#edit-modal #edit-kodebarang').val(data_kodebarang);
	    	$('#edit-modal #edit-namabarangdrp').val(data_namabarangdrp);
	    	$('#edit-modal #edit-newprice').val(data_newprice);
	    });

	    // BUTTON DELETE
	    $('.button_delete').click(function (e) {
	        e.preventDefault();
			// GET DATA    	    
			var data_row=$(this).closest("tr").find(".data_row").text();
			var data_barcode = $(this).closest("tr").find(".data_barcode").text();
    	    var data_namabarang = $(this).closest("tr").find(".data_namabarang").text();
    	    var data_kodebarang = $(this).closest("tr").find(".data_kodebarang").text();
    	    var data_namabarangdrp = $(this).closest("tr").find(".data_namabarangdrp").text();
    	    var data_newprice = $(this).closest("tr").find(".data_newprice").text();
			
	    	// SET DATA TO DELETE MASTER FORM
			$('#delete-modal #delete-row').val(data_row);
	    	$('#delete-modal #delete-barcode').val(data_barcode);
	    	$('#delete-modal #delete-namabarang').val(data_namabarang);
	    	$('#delete-modal #delete-kodebarang').val(data_kodebarang);
	    	$('#delete-modal #delete-namabarangdrp').val(data_namabarangdrp);
	    	$('#delete-modal #delete-newprice').val(data_newprice);
	    });
    
    </script>

	
</body>
</hmtl>
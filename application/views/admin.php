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
			<section>
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class = "text-center" style = "vertical-align : middle">Number</th>
								<th class = "text-center" style = "vertical-align : middle">Barcode</th>
								<th class = "text-center" style = "vertical-align : middle">Nama Barang</th>
								<th class = "text-center" style = "vertical-align : middle">Kode Barang</th>
								<th class = "text-center" style = "vertical-align : middle">Nama Barang (DRP)</th>
								<th class = "text-center" style = "vertical-align : middle">New Price</th>
								<th class = "text-center" style = "vertical-align : middle">Action</th>
							</tr>
						</thead>
				    	<tbody>
				    		<?php 
				    		foreach($informasi_db_excel as $key_db_excel => $value_db_excel) {
				    		?>
							<tr>
								<td><?php echo $key_db_excel+1;?></td>
								<td><?php echo $value_db_excel['barcode'];?></td>
								<td><?php echo $value_db_excel['namabarang'];?></td>
								<td><?php echo $value_db_excel['kodebarang'];?></td>
								<td><?php echo $value_db_excel['namabarangdrp'];?></td>
								<td><?php echo $value_db_excel['newprice'];?></td>
								<td>Update | Delete</td>
							</tr>
							<?php
							}
							?>
						</tbody>
				  	</table>
				</div>
			</section>
		</main>
	</div>
	<footer class = "container">
		<?php $this->load->view('include/footer'); ?>		
	</footer>
</body>
</hmtl>
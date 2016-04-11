<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="yohanesboyoh">
	<title>Excelreader - Home</title>

	<link href="<?=base_url()?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?=base_url()?>css/excelreader.css" rel="stylesheet">
</head>

<body>

	<div class = "wrapper">
		<header class = "container">
			<?php $this->load->view('include/navigation'); ?>
		</header>

		<main class = "container">
			<h1 id = "title-page" class = "text-center">Welcome to Convert Machine !!!</h1>
			<h3 class = "text-center">Please, select your menu.</h3>
		</main>

	</div>
	<footer class = "container">
		<?php $this->load->view('include/footer'); ?>
	</footer>

</body>

</hmtl>
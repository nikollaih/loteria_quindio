<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php echo (isset($title)) ? $title : "Lotería del Quindío" ?></title>
	<meta name="description" content="The small framework with powerful features">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
	<link rel="stylesheet" href="<?= base_url().'assets/css/main.css' ?>">
	<script>
		// Define the base url for js files
		var base_url = "<?= base_url(); ?>"
	</script>
</head>
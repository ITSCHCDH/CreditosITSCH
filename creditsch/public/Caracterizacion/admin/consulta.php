<!DOCTYPE html>
<html lang="es">
<head>
	<title>STE-ITCH</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="../css/styles.css" />
	<link rel="stylesheet" type="text/css" href="../css/sbimenu.css" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<script type="text/javascript" src="./../js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="./../js/jquery.bgImageMenu.js"></script>
	<script type="text/javascript">
		$(function() {
			$('#sbi_container').bgImageMenu({
				defaultBg	: '../pic/5.jpg',
				menuSpeed	: 300,
				type		: {
					mode		: 'horizontalSlide',
					speed		: 250,
					easing		: 'jswing',
					seqfactor	: 100
				}
			});
		});
	</script>
</head>
<body>
	<div class="container">
		<br>
		<div class="topbar">
			<a><span>Administrador </span></a>
			<span class="right_ab">
				<a href="index.php"><strong> Ir a Inicio</strong></a>
			</span>
		</div>
		
		<div class="content">
			<br>
			<div id="sbi_container" class="sbi_container">
				<div class="sbi_panel" data-bg="../pic/1.jpg">
					<a class="sbi_label">Consulta</a>
					<div class="sbi_content">
						<ul>
							<li><a href="consulta_individual.php">Individual</a></li>
							<li><a href="consulta_grupal.php">Grupal</a></li>
							<li><a href="consulta_carrera.php">Carrera</a></li>
							
						</ul>
					</div>
				</div>
				<div class="sbi_panel" data-bg="../pic/2.jpg">
					
				</div>
				<div class="sbi_panel" data-bg="../pic/6.jpg">
					
				</div>
			</div>
		</div>
		<div class="topbar">
			<a><span><i>Inicio / Consulta</i></span></a>
		</div>
	</div>
</body>
</html>
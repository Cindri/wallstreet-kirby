<?php
// echo $_GET['produkt']."<br>";
// echo $_GET['content']."<br><br>";
// echo preg_match("%index\.html/(.*)/(.*)%", "index.html/Test1/Test2", $matches) ? "Treffer: <br>".print_r($matches) : "kein Treffer";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<base href="http://wp1091580.wp126.webpack.hosteurope.de/rewrite/">
	<head>
		<title>Buenoson Design-Entwurf</title>
		<link rel="stylesheet" type="text/css" href="style_main.css">
	</head>
	<body>
		<div id="page_border">
		<div id="page">
			<div class="kopf">
			<img src="images/oben.jpg" width="1000" height="349" alt="Buenoson Kopfbild und Firmenlogo Zilly">
			</div>
			<div class="navi">
				<div class="navi_sub">
					<img class="navibild" src="images/buenoson_oel.jpg" width="240" height="36">
					<ul>
						<li><a href="index.php/fusspflegeoel/wirkstoffe">Wirkstoffe</a></li>
						<li><a href="index.php/fusspflegeoel/wirkungsweise">Wirkungsweise</a></li>
						<li><a href="index.php/fusspflegeoel/anwendungsgebiete">Anwendungsgebiete</a></li>
					</ul>
				</div>
				<div class="navi_sub" style="margin-top:40px;">
					<img class="navibild" src="images/buenoson_balsam.jpg" width="240" height="36">
					<ul>
						<li><a href="index.php/balsam/wirkstoffe">Wirkstoffe</a></li>
						<li><a href="index.php/balsam/wirkungsweise">Wirkungsweise</a></li>
						<li><a href="index.php/balsam/anwendungsgebiete">Anwendungsgebiete</a></li>
					</ul>
				</div>
				<div class="navi_sub" style="margin-top:40px;">
					<img class="navibild" src="images/bueno.jpg" width="240" height="36">
					<ul>
						<li><a href="index.php/bueno_balsam/wirkstoffe">Wirkstoffe</a></li>
						<li><a href="index.php/bueno_balsam/wirkungsweise">Wirkungsweise</a></li>
						<li><a href="index.php/bueno_balsam/anwendungsgebiete">Anwendungsgebiete</a></li>
					</ul>
				</div>
			</div>
			<div class="content">
				<?php
				switch($_GET['produkt'])
				{
					case "fusspflegeoel":
						$headimage = "buenoson_oel.jpg";
						$content = "oel_";
						switch ($_GET['content'])
						{
							case "wirkstoffe":
								$content .= "1.php";
								$header = "Wirkstoffe";
							break;
							case "wirkungsweise":
								$content .= "2.php";
								$header = "Wirkungsweise";
							break;
							case "anwendungsgebiete":
								$content .= "3.php";
								$header = "Anwendungsgebiete";
							break;					
							default:
								$content .= "1.php";
								$header = "Wirkstoffe";
							break;				
						}
					break;
					
					case "balsam":
						$headimage = "buenoson_balsam.jpg";
						$content = "balsam_";
						switch ($_GET['content'])
						{
							case "wirkstoffe":
								$content .= "1.php";
								$header = "Wirkstoffe";
							break;
							case "wirkungsweise":
								$content .= "2.php";
								$header = "Wirkungsweise";
							break;
							case "anwendungsgebiete":
								$content .= "3.php";
								$header = "Anwendungsgebiete";
							break;					
							default:
								$content .= "1.php";
								$header = "Wirkstoffe";
							break;						
						}
					break;
					
					case "bueno_balsam":
						$headimage = "bueno.jpg";
						$content = "bueno_balsam_";
						switch ($_GET['content'])
						{
							case "wirkstoffe":
								$content .= "1.php";
								$header = "Wirkstoffe";
							break;
							case "wirkungsweise":
								$content .= "2.php";
								$header = "Wirkungsweise";
							break;
							case "anwendungsgebiete":
								$content .= "3.php";
								$header = "Anwendungsgebiete";
							break;					
							default:
								$content .= "1.php";
								$header = "Wirkstoffe";
							break;
						}
					break;
					
					case "kontakt":
						$content = "kontakt.php";
					break;
					
					case "impressum":
						$content = "impressum.php";
					break;
					
					default:
						$headimage = "buenoson_oel.jpg";
						$content = "oel_1.php";
						$header = "Wirkstoffe";
					break;
				}
				
				include("content/".$content);
				?>
				
			</div>
			<div class="fuss">
				<div style="float:right; margin-right:0px;">&copy; Fritz Zilly GmbH, Baden-Baden &middot; Alle Rechte vorbehalten</div>
				<a href="index.php/kontakt/">Kontakt</a> | <a href="index.php/impressum/">Impressum</a>
			</div>
		</div>
		</div>
	</body>
</html>
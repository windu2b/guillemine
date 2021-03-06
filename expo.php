<?php error_reporting( E_ALL ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" media="all" href="./styles/menu.css" />
<link rel="stylesheet" type="text/css" media="all" href="./styles/main.css" />
<link rel="stylesheet" type="text/css" media="all" href="./styles/galerie.css" />
<title>Christelle Guillemine</title>
</head>
<body>
	<div id="menu">
		<ul>
			<li>Christelle<br />Guillemine</li>
			<li><a href="index.php">Accueil</a></li>
			<li><a href="galerie.php" class="current">Galerie</a></li>
			<li><a href="expo.php">Exposition/Vernissage</a></li>
			<li><a href="livre_or.php">Livre d'Or</a></li>
			<li><a href="contact.php">Contact</a></li>
		</ul>
		<br class="clearer" />
	</div>
	<hr />
	<div id="main">
		<span class="mainTitle">Galerie</span> <br />
		<div id="galeries">
<?php
			require_once( dirname(__FILE__ ) . '/conf/config.inc.php');
			try
			{
				$selectGaleries = "	SELECT	g.id AS id_galerie,
											g.nom AS nom_galerie,
											p.id AS id_peinture,
											p.nom AS nom_peinture
									FROM
									(
										SELECT	g.id,
												g.nom,
												(
													SELECT	p.id
													FROM	peintures p
													WHERE	p.id_galerie = g.id
													ORDER BY RAND()
													LIMIT 1
												) AS p_random
										FROM	galeries g
									) g
									LEFT JOIN peintures p
										ON p.id = g.p_random
									ORDER BY g.id DESC";
				$select = $cnx->query( $selectGaleries );
				$select->setFetchMode(PDO::FETCH_OBJ);
	
				$i = 0;
				while ($galerie = $select->fetch() )
				{
					echo '<span class="theme">
							<a href="galerie.php?id_galerie=' . $galerie->id_galerie . '"><img src="./peintures/vignettes/' . $galerie->id_peinture . '.jpg" /></a>
							<span class="titre">' . $galerie->nom_galerie . '</span>
						</span>';
					if( ++$i % 3 == 0 )
						echo '<br />';
				}
			}
			catch( PDOException $e )
			{
				echo 'Connexion échouée : ' . $e->getMessage();
			}
?>
		</div>
	</div>
	<br class="clearer" />
</body>
</html>
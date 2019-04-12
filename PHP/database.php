<?php 
	$servername = "localhost";
	$username = "root";
	$password = "mysql";
	$myDB = "Planningstool";
	header('Content-type: text/html; charset=iso-8859-1');
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$myDB", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// echo "Connected Successfully";
	}

	catch(PDOException $e)
	{
		echo "Connection failed:" . $e->getMessage();
	}

	$sql = 'SELECT * FROM games';
	$query = $conn->prepare($sql);
	$query->execute();

	$result = $query->fetchAll();
	// var_dump($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="../CSS/style.css">
  <meta charset="utf-8">
</head>
<body>
	<h1>Planningstool</h1>
	<a href="geplandegames.php"><button>Geplande games</button></a>
	<table border="1">
		<tr>
			<th>ID</th>
			<th>Naam</th>
			<th>Afbeelding</th>
			<th>Skills</th>
			<th>Min. Spelers</th>
			<th>Max. Spelers</th>
			<th>Speel tijd(minuten)</th>
			<th>Uitleg Duur(minuten)</th>
			<th>Detail Pagina</th>
		</tr>
		<?php 
			foreach($result as $row){
		?>
		<tr>
			<td><?php echo $row['id'] ?></td>
			<td><?php echo $row['name'] ?></td>
			<td><img class="gameimage" src="../afbeeldingen/<?php echo $row['image']; ?>"></td>
		<!-- 	<td><a href="detail.php?nummer=<?php
			echo $row['id'] ?>">1235</a></td> -->
			<td><?php echo $row['skills'] ?></td>
			<td><?php echo $row['min_players'] ?></td>
			<td><?php echo $row['max_players'] ?></td>
			<td><?php echo $row['play_minutes'] ?></td>
			<td><?php echo $row['explain_minutes'] ?></td>
			<td><a href="detail.php?number=<?php echo $row['id'] ?>">Detail Pagina</a></td>
		</tr>

<!-- 	<?php 
		$id = $_GET['nummer']
	?> -->

		<?php 
			}
		?>
	</table>

</body>
</html>

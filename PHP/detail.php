<?php 
	$servername = "localhost";
	$username = "root";
	$password = "mysql";
	$myDB = "Planningstool";
	$inputAmount = 1;
	$answer = [];
	$speler = [];
	$Err = [];
	$errors = 0;

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

	$id = $_GET["number"];

	// $sql = 'SELECT * FROM posts WHERE author = ?';
	// $stmt = $pdo->prepare($sql);
	// $stmt->execute([$author]);
	// $posts = $stmt->fetchAll();
  
//FETCH SINGLE POST
	$sql = "SELECT * FROM games WHERE id = :id";
	$stmt = $conn->prepare($sql);
	$stmt->execute(["id" => $id]);
	$post = $stmt->fetch();

		while ($inputAmount <= $post["max_players"]){
		array_push($speler, $inputAmount);
		array_push($answer, $inputAmount);
		$inputAmount++;
	}

	function test_input($data) {
	  $data = trim($data); //Zorgt ervoor dat onnodige space, tab, newline worden weggehaald.
	  $data = stripslashes($data); //verwijderd backslashes (\).
	  $data = htmlspecialchars($data); //Dit zorgt ervoor dat speciale karakters naar html veranderd waardoor je niet gehackt kan worden.
	  return $data;
	}
  ?>

<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="../CSS/style.css">
  <link rel="stylesheet" type="text/css" href="../CSS/detail.css">
  <meta charset="utf-8">
</head>
<body>
	<a href="database.php"><button>Terug</button></a>
<div class="style">
	<div class="name">
		<h1><?php echo $post['name']?></h1>
		<img class="example" src="../afbeeldingen/<?php echo $post['image']?>">
		<p class="text"><?php echo $post['description'] ?></p>
	</div>

	<div class="extra">
		<h1>Extra informatie</h1>
		<a href="<?php echo $post['url'] ?>">Officiele site</a>
		<p>Expansions: <?php echo $post['expansions'] ?></p>
		<p>Skills: <?php echo $post['skills'] ?></p>
		<p>Minimale spelers: <?php echo $post['min_players'] ?></p>
		<p>Maximale spelers: <?php echo $post['max_players'] ?></p>
		<p>Speeltijd: <?php echo $post['play_minutes'] ?></p>
		<p>Tijd voor uitleggen: <?php echo $post['explain_minutes'] ?></p>
	</div>

	<div class="video">
		<?php echo $post['youtube'] ?>
	</div>

<form method="POST">
	<div class="form">
	<?php foreach ($speler as $key => $value){
			if (empty($_POST[$key])){
			    $Err[$key] = "Je moet iets invullen";
			    $errors++;
			} 

			$speler[$key] = test_input($_POST[$key]);
				if(!preg_match("/^[a-zA-Z ]*$/",$_POST[$key])){
				    $Err[$key] = "Je mag alleen letters en witruimte gebruiken.";
				    $errors++;
				}?>
		<p>Naam player <?php echo $value ?></p>
		<input type="text" name="<?php echo $key ?>" value=""> 
		<div class="error"><?php echo $Err[$key]; ?></div>
	<?php } ?>
	</div>

	<div class="uitleg">
		<p>Naam uitleg</p>
		<input type="text" name="uitleg" placeholder="Uitleg"> 
	</div>

	<div class="uitleg">
		<p>Start tijd</p>
		<input type="text" name="start" placeholder="00:00"> 
	</div>

	<button style="margin-top: 20px;">Bevestigen</button>
</form>

</div>


</body>
</html>
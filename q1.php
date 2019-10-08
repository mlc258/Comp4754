<html>
<body>
<?php

     define('DB_NAME' , 'MyBase');
     define('DB_USER' , 'mlc258');
     define('DB_PASSWORD', 'tldDKG0F');
     define('DB_HOST', 'localhost');

     $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

     if(!$link) {
        die('Could not connect: '. mysql_error());
     }

     $db_selected = mysql_select_db(DB_NAME, $link);

     if(!$db_selected){
        die('Can\'t use' . DB_NAME . ': ' .mysql_error());
     }

     echo 'Connected.';

     $pname = $_POST['pname'];
     $checkArray = [];

	if (array_key_exists("sid", $_POST)){
			array_push($checkArray, "S." . $_POST['sid']);
	}

	if (array_key_exists("sname", $_POST)){
			array_push($checkArray, "S." . $_POST['sname']);
	}

	if (array_key_exists("saddress", $_POST)){
			array_push($checkArray, "S." . $_POST['saddress']);
	}

	if (array_key_exists("cost", $_POST)){
			array_push($checkArray, $_POST['cost']);
	}

	function selectString($array){
		$select = "";
		for($i = 0; $i < count($array); $i++){
			$select .= $array[$i];

			if ($i != count($array) - 1){
				$select .= ", ";
			} 
		}

		return $select;
	}
	$query= 
	"	
	SELECT " . selectString($checkArray) . "
	FROM Suppliers S, Parts P, Catalog C 
	WHERE S.sid=C.sid AND P.pid=C.pid AND P.pname='$part_name'
	";

	$result = $link->query($query);

	if (!result){
		die('Invalid query: ' . mysql_error());
	}
	if ($result->num_rows > 0){ 
		while($row = $result ->fetch_assoc()){
			foreach ($row as $info => $value){
				echo $info . ": $value<br>";
			}
			echo "<br>";
		}
	}
	else{
		echo "No results found";
	}
	$link->close();
?>
</body>
</html>

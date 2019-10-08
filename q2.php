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

     $cost = $_POST['cost'];
     $query = "
            SELECT S.sname
	    FROM Suppliers S
	    WHERE S.sid IN ( SELECT S.sid
			FROM Suppliers S, Catalog C
			WHERE S.sid = C.sid AND C.cost >= $cost );

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

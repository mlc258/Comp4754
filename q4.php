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

     $address = $_POST['address'];
     $color = $_POST['color'];
     $query= 
	"	
	SELECT  P.pname
	FROM  Parts P
	WHERE  NOT EXISTS (SELECT S.sid
			   FROM  Suppliers S
			   WHERE  S.address = $address AND NOT EXISTS
			          (SELECT  C.sid
			           FROM  Catalog C
			           WHERE C.pid = P.pid AND C.sid = S.sid AND P.color = $color))";

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

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

     $pid = $_POST['pid'];
     $query= 
	"	
	SELECT  S.sname, S.address
	FROM Suppliers S, Catalog C, Parts P
	WHERE C.pid = P.pid AND C.sid = S.sid AND P.pid = $pid AND C.cost = (
		SELECT MAX(C1.cost)
		FROM Catalog C1
		WHERE C1.pid = P.pid);";

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

<?php
$host = 'localhost';
$pass = '';
$user = 'root';
$database = 'registration';
@$sqlconnect = mysqli_connect($host, $user, $pass, $database);
//@$dbconnect = mysqli_select_db($sqlconnect, $database);
if($sqlconnect)
{

}
else{

	echo "Connection to database failed! ";
}


?>

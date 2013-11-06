<?php
require_once("reserved_slots.php");

//##########################################################
$user = "";
$password = "";
$hostname = "localhost"; 

$dbhandle = mysql_connect($hostname, $user, $password) 
 or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

$selected = mysql_select_db("",$dbhandle) 
  or die("Could not select database");
  
//#############################################################
 
//$oldReservedPlayers = mysql_query("SELECT player_name FROM adkats_accesslist where access_level = 5");
	function oldReservedPlayers($alevel = 5){
	
    $query = mysql_query("SELECT player_name, access_level FROM adkats_accesslist where find_in_set('{$alevel}', access_level)");
		while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
        $oldReservedPlayers[] = $row['player_name'];
        }
	if (count($oldReservedPlayers))
	{
		return implode("\n", $oldReservedPlayers);
	}
	else
	{
		return ("Ingen i klasse ". $alevel);
	}	
}
$oldReservedPlayers = oldReservedPlayers(5)."\n";

echo $reservedPlayers."\n";
echo $oldReservedPlayers."\n";

$new_players = array_diff($reservedPlayers, $oldReservedPlayers);
$old_players = array_diff($oldReservedPlayers, $reservedPlayers);

foreach ($new_players as &$new)
	{
	$new_players[$new];
	}
	return $new;
	/*
	$query = 'INSERT INTO `adkats_accesslist` (`player_name`, `member_id`, `player_email`, `access_level`) VALUES ("'.$new.'", 0, "test@gmail.com", 5)';
	//mysql_query($query);
	$result = mysql_fetch_array($query) or die(mysql_error());
	// Check result
// This shows the actual query sent to MySQL, and the error. Useful for debugging.
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}*/
/*
foreach ( $old_players as &$old) 
	{
	$old_players[$old];
	}
	$query = 'DELETE FROM adkats_accesslist WHERE player_name = '.$old.'';
	$result = mysql_query($query) or die(mysql_error());
*/
mysql_close($dbhandle);
?>
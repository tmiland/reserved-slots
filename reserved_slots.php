<?php

	require_once("../../class2.php");
	function reservedPlayers($uclass = 1){

    $u_sql = new db();
	$result = array();
     
    $query = "SELECT user_id, user_class, user_name FROM #user WHERE find_in_set('{$uclass}', user_class) ORDER BY user_id";

    if ($u_sql->db_Select_gen($query, true)){

        while ($row = $u_sql->db_Fetch(MYSQL_ASSOC)){
           $result[] = $row['user_name'];
        }
       
    }
	if (count($result))
	{
		return implode("\n", $result);
	}
	else
	{
		return ("Ingen i klasse ". $uclass);
	}
	}
	$reservedPlayers = reservedPlayers(1)."\n".reservedPlayers(8);
	$names = explode("\n", $reservedPlayers);
	$names = array_unique($names);
	$reservedPlayers = implode("\n", $names);

	$file = "reserved_slots.txt";
	$handle = fopen($file, 'w') or die("can't open file");
	$data = $reservedPlayers;
	fwrite($handle, $data); 
	fclose($handle);
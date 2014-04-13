<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require_once("../../class2.php");

	$reservedPlayers = array();
	function reservedPlayers($uclass = 1) {
		$u_sql = new db();
		$query = "SELECT * FROM #user AS u LEFT JOIN #user_extended AS e ON u.user_id = e.user_extended_id WHERE find_in_set('{$uclass}', user_class) ORDER BY user_name";

		if ($u_sql->db_Select_gen($query)) {
				while ($row = $u_sql->db_Fetch(MYSQL_ASSOC)){
						$result[] = $row['user_bf3playername'];
				}
		}
		return $result;
	}

	$class_1 = reservedPlayers(1);
	$class_8 = reservedPlayers(8);

	if (count($class_1)) {
		$reservedPlayers = array_merge($reservedPlayers, $class_1);
	}
	if (count($class_8)) {
		$reservedPlayers = array_merge($reservedPlayers, $class_8);
	}

	$reservedPlayers = array_unique($reservedPlayers);
	
	require_once("new_db.php");
	/*-------------------Player Class--------------------*/
	class Player {

		function add($player_identifier, $player_group) {
			$player_identifier = trim($player_identifier);

				// Check if the player_identifier is already in the database
					// player_identifier is not in the database yet. Create a entry in the "player" table ...
					$query = "INSERT INTO adkats_specialplayers (player_identifier, player_group) VALUES ('.$player_identifier.', '.$player_group.')";
					$player_id = player_id;
					//$player_id[] = $row['player_id'];
					//$this->sql->player_id;

					// Generate message with $player_identifier in phrase
					$message = "Add player";
					eval ( "\$message = \"$message\";" );
					return $message;
		}

/*		function delete($player_id = NULL, $player_identifier = NULL) {
				$query = "DELETE FROM adkats_specialplayers WHERE player_id = '".$player_id."'";
				$message = "Delete player";
				eval ( "\$message = \"$message\";" );
				return $message;
		}
*/	}
	/*-------------------End Player Class----------------*/
	$player = new Player();
	$AdKatsSpecialPlayer	= array();
	$player_in_db = Array();
	$group_of_players = Array();
	$player_in_database = Array();
	$message = Array();
	
	foreach ($reservedPlayers as $rp) {
		$player_in_db[] = $rp[0];
		$group_of_players[] = $rp[1];
	}
	$sql->db_Select_gen('SELECT player_id, player_identifier FROM adkats_specialplayers ORDER BY player_identifier');
	while ($row = $sql->db_Fetch(MYSQL_ASSOC)) $player_in_database[$row['player_id']] = $row['name'];

	for($i = 0; $i < count($player_in_db); $i++) {
		$player_identifier = $player_in_db[$i];
		$player_group = $group_of_players[$i];
		
		if (!in_array($player_identifier, $player_in_database)) {
			$message[] = $player->add($player_identifier, $player_group, false);
		}
	}
	
	foreach ($player_in_database as $player_id => $player_identifier) {
		if (!in_array($player_identifier, $player_in_db)) {
			$message[] = $player->delete($player_id, $player_identifier);
		}
	}

	echo "<pre>";
	print_r($message);

mysqli_close($sql);
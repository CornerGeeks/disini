<?php require_once("header.php"); 


function new_user($username,$password){
	$existing=R::findOne("user","username = ?",array($username));	
	if($existing->id) return false;
	
	//ooh. I should do the socials oauth
	$user = R::dispense("user");
	$user->name = $username;
	$user->password = hasher($password);
	$id= R::store($user);
	
	return $id;
}

function check_user($username,$password){
	$existing=R::findOne("user","username = ?", array($username));
	if($existing->id){
		if(check_hash($password,$existing->password)){
			return $existing->id;
		}
	}
	return false;
}

function find_service($string,$position){ //string is search string? pos array(lat,lang)

}

function create_service($user_id,$info){ //pass $_POST to $info?? contains service, description, tags?
	
}





?>
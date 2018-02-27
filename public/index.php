<?php

 require_once("../includes/initialize.php");

//if(isset($database)) { echo "true"; }  else {echo "false;"; }
echo "<br />";
//echo $database->escape_value("It's working?")."<br />";


////insert data into the database
//$user = new User();
//$user->username = "johnsmith";
//$user->password = "abcd1234";
//$user->first_name = "John";
//$user->last_name = "Smith";
//$user->create();

//update data into the database
//$user = User::find_by_id(4);
//$user->password = "1234abcd";
////$user->update();
//$user->save();

//delete data from the table
$user = User::find_by_id(3);
$user->delete();
echo $user->first_name . " was deleted";

//echo "<hr />";
//
////Fetch user by id
//$user = User::find_by_id(1);
//echo $user->full_name();
//
//echo "<hr />";
////Fetch all user
//$users = User::find_all();
//foreach($users as $user){
// echo "User: " . $user->username . "<br />";
// echo "Name: " . $user->full_name() . "<br /><br />";
//}
?>
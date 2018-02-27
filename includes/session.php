<?php

/**
 * Created by PhpStorm.
 *
 * Date: 2/17/2018
 * Time: 12:20 PM
 */
//Keep in mind when working with sessions that it is generally inadvisable to store DB-related objects in session
class Session{

    private $logged_in = false;
    public $user_id;

    function __construct(){
        session_start();
        $this->check_login();
        if($this->logged_in){
            //action to take right away if user is logged in
        } else {
            //action to take right away if the user is not loggined in
        }
    }

    private function check_login(){
        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }

    public function is_logged_in(){
        return $this->logged_in;
    }

    public function login($user){
        // database should find user based on username/password
        if($user){
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->logged_in = true;
        }
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->logged_in = false;
    }
}

$session = new Session();

?>
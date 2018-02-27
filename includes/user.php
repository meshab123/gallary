<?php

require_once(LIB_PATH.DS.'database.php');
//require_once("database.php");
//requre_once(LIB_PAHT.DS."database_object.php");

class User extends DatabaseObject{
    protected static $table_name = "users";
    protected static $db_fields = array('id','username','password','first_name','last_name');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

    public function full_name(){
        if(isset($this->first_name) && isset($this->last_name)){
            return $this->first_name . " " . $this->last_name;
        } else {
            return "";
        }
    }

    public static function authenticate($username="",$password=""){
        global $database;
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);

        $sql = "SELECT * FROM users ";
        $sql .= "WHERE username = '{$username}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public function save(){
    //A new records won't have an id yet
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create(){
        global $database;
        $sql = "INSERT INTO ".self::$table_name." (";
        $sql .= "username,password,first_name,last_name";
        $sql .= ") VALUES ('";
        $sql .= $database->escape_value($this->username) . "', '";
        $sql .= $database->escape_value($this->password) . "', '";
        $sql .= $database->escape_value($this->first_name)."', '";
        $sql .= $database->escape_value($this->last_name). "')";
         if($database->query($sql)){
             $this->id = $database->insert_id();
             return true;
         } else {
             return false;
         }
    }

    public function update(){
       global $database;
        $sql = "UPDATE ".self::$table_name." SET ";
        $sql .= "username='". $database->escape_value($this->username). "', ";
        $sql .= "password='". $database->escape_value($this->password)."', ";
        $sql .= "first_name='" .$database->escape_value($this->first_name)."', ";
        $sql .= "last-name='" .$database->escape_value($this->last_name)."', ";
        $sql .= "WHERE id=".  $database->escape_value($this->id);
        $database->query($sql);
        return($database->affected_rows()===1)? true : false;

    }

    public function delete(){
        global $database;
        $sql = "DELETE FROM ".self::$table_name;
        $sql .= " WHERE id=". $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return($database->affected_rows()===1) ? true : false;
    }

//    //Common Database Methods
//    public static function find_all(){
//        return self::find_by_sql("SELECT * FROM " .self:: $table_name);
//    }
//
//    public static function find_by_id($id=0){
//        global $database;
//        $result_array = self::find_by_sql("SELECT * FROM
// " .self::$table_name." WHERE id={$id} LIMIT 1");
//       return !empty($result_array) ? array_shift($result_array) : false;
//    }
//
//    public static function find_by_sql($sql=""){
//        global $database;
//        $result_set = $database->query($sql);
//        $object_array = array();
//        while($row = $database->fetch_array($result_set)){
//            $object_array[] = self::instantiate($row);
//        }
//        return $object_array;
//    }
//
//
//    public function create_user($users){
//        self::insert_user($users);
//    }
//
//    private static function insert_user($users){
//
//    }
//
//    private static function instantiate($record){
//        $object = new self;
////        $object->id =         $record['id'];
////        $object->username =   $record['username'];
////        $object->password =   $record['password'];
////        $object->first_name = $record['first_name'];
////        $object->last_name =  $record['last_name'];
//
//        //More dynamic, short-form approach:
//        foreach($record as $attribute=>$value){
//            if($object->has_attribute($attribute)){
//                $object->$attribute = $value;
//            }
//        }
//        return $object;
//    }
//
//    private function has_attribute($attribute){
//        // Get_object_vars returns an associative array with all attributes
//        //incl. private ones! as the keys and their current values as the value
//        $object_var = get_object_vars($this);
//        //We don't care about the value, we just want to know if the key exists, will return true or false
//        return array_key_exists($attribute,$object_var);
//    }
}


?>
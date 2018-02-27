<?php
require_once(LIB_PATH.DS."database.php");
//**use of late static binding.

class DatabaseObject{
  //  protected static $table_name = "users";
    //Common Database Methods
    public static function find_all(){
        //use of late static binding: replace self to static
        return static::find_by_sql("SELECT * FROM " .static::$table_name);
    }

    public static function find_by_id($id=0){
        global $database;
        //use of late static binding: replace self by static
        $result_array = static::find_by_sql("SELECT * FROM
 " .static::$table_name." WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_by_sql($sql=""){
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while($row = $database->fetch_array($result_set)){
            $object_array[] =static::instantiate($row);
        }
        return $object_array;
    }

    private  function has_attribute($attribute){
        // Get_object_vars returns an associative array with all attributes
        //incl. private ones! as the keys and their current values as the value
        $object_var = $this->attributes();
        //We don't care about the value, we just want to know if the key exists, will return true or false
        return array_key_exists($attribute,$object_var);
    }

    protected function attributes(){
        //return an array of attribute keys and their values.
         $attributes = array();
        foreach(static::$db_fields as $field_){
            if(property_exists($this, $field_)){
                $attributes[$field_] = $this->$field_;
            }
        }
         return $attributes;
        //this will return all other private fields which is not a database fields
        //return get_object_vars($this);
    }

    protected function sanitized_attributes(){
        global $database;
        $clean_attributes = array();
        // sanitize the values before submitting
        //Note: does not alter the actual value of each attribute
        foreach($this->attributes() as $key=>$value){
            $clean_attributes[$key] = $database->escape_value($value);
        }

        return $clean_attributes;
    }

    private static function instantiate($record){
        //$object = new self;
        $class_name = get_called_class();
        $object = new $class_name;
//        $object->id =         $record['id'];
//        $object->username =   $record['username'];
//        $object->password =   $record['password'];
//        $object->first_name = $record['first_name'];
//        $object->last_name =  $record['last_name'];

        //More dynamic, short-form approach:
        foreach($record as $attribute=>$value){
            if($object->has_attribute($attribute)){
                $object->$attribute = $value;
            }
        }
        return $object;
    }



    public function save(){
        //A new records won't have an id yet
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create(){
        global $database;

        //don't forget your SQL syntax and good habits:
        //Single-Quotes around all values
        //escape all values to prevents SQL injection
        $attributes = $this->sanitized_attributes();

        $sql = "INSERT INTO ".static::$table_name." (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        if($database->query($sql)){
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }

    public function update(){
        global $database;
        //UPDATE table SET key='value',key='value' WHERE condition
        //single-Quotes around all values
        //escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        $attributes_pair = array();
        foreach($attributes as $key=>$value){
            $attributes_pair = "{$key}='{$value}'";
        }
        $sql = "UPDATE ".static::$table_name." SET ";
        $sql .= join(", ", $attributes_pair);
        $sql .= " WHERE id=".  $database->escape_value($this->id);
        $database->query($sql);
        return ($database->affected_rows()===1)? true : false;

    }

    public function delete(){
        global $database;
        $sql = "DELETE FROM ".static::$table_name;
        $sql .= " WHERE id=". $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return($database->affected_rows()===1) ? true : false;
    }




}
?>
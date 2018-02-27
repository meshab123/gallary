<?php
function strip_zero_from_date($marked_string=''){
    //first remove the marked zero
    $no_zeros = str_replace('*0','',$marked_string);
    //remove any remaining mark
    $cleaned_string = str_replace('*','',$no_zeros);

    return $cleaned_string;
}

function redirect_to($location=NULL){
    if($location !=NULL){
        header("LOCATION:{$location}");
        exit;
    }
}

function output_message($message=""){
    if(!empty($message)){
        return "<p class=\"message\">{$message}</p>";
    } else {
        return '';
    }
}

//auto load is a safty net in case we forgot to includes the required file in main page, so that will not get error.
function __autoload($class_name){
    $class_name = strtolower($class_name);
    $path = LIB_PATH.DS."{$class_name}.php";
    if(file_exists($path)){
        require_once($path);
    } else {
        die("The file {$class_name}.php could not be found. ");
    }
}

//layout template
function include_layout_template($template="") {
    include(SITE_ROOT.DS.'public'.DS.'layout'.DS.$template);
}



<?php

class Session {
    // Method to start a session; can be called directly without creating an instance of the class first
    public static function start(){
        // Check if session is not already started, then start it
        if(empty($_SESSION)) session_start();
    }

    // Method to set a session variable
    public static function set($session_name, $value){
        // Set the session variable
        $_SESSION[$session_name] = $value;
    }

    // Method to get the value of a session variable
    public static function get($session_name){

        // Check if the session variable is set, then return its value
        // Otherwise, return false
        if(isset($_SESSION[$session_name])){
            return $_SESSION[$session_name];
        }else {
            return false;
        }
    }

    // Method to destroy a session variable
    public static function destroy($session_name){
        // Check if the session variable is set, then unset it
        if(isset($_SESSION[$session_name])) unset($_SESSION[$session_name]);
    }

    // Method to check if a session variable exists
    public static function exists($session_name){
        /*var_dump($session_name);
        die();*/
        if(isset($_SESSION[$session_name]))  return true;
        // Check if the session variable exist
        return false;
    }
}

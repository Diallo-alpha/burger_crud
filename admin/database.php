<?php
class Database {
    private static $servername = "localhost";
    private static $dbname = "burger_code";
    private static $username = "root";
    private static $password = "";

    private static $connexion = null;

    public static function connect () {
    try{
        self::$connexion = new PDO("mysql:host=".self::$servername.";dbname=" .self::$dbname,self::$username,self::$password);
        self::$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){

        die('ERREUR '.$e->getMessage());
    }
    return self::$connexion;
}

public static function disconnect () 
{
    self::$connexion = null;
}

}
 ?>

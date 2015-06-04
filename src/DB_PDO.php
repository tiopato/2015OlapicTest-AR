<?php
/**
 * DB Acces class
 * @author Ariel Gonzalo Romero
 * @since 2015-05-19
 * Aproach to singleton pattern in order to optimize the connections
 **/
namespace olapictest;
 
class dbConn
{
    //Singleton Pattern variable
    protected static $db;

    /**
    * Default constructor.
    * @param string $host 
    * @param string $database 
    * @param string $user
    * @param string password
    */
    private function __construct($host = 'localhost',$db = 'olapictest',$usr = 'root',$pass = '') 
    {
        try {
            self::$db = new PDO('mysql:host='.$host.';dbname='.$db.'', $usr, $pass);
            self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } 
        catch (PDOException $e) 
        { 
          die("DB CONNECTION ERROR: " . $e->getMessage());
        }
    }


    /**
    * Getters & Setters
    **/
    
    /**
    * Get the singleton DB connection Object
    * @return dbConn Connection object
    */
    
    public static function getConnection() 
    {
        if (!self::$db) 
        {
            new dbConn();  //new connection object.
        }
        return self::$db;
    }
}
?>
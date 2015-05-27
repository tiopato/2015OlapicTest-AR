<?php
/**
 * DB Acces class
 * @author Ariel Gonzalo Romero
 * @since 2015-05-19
 * It uses a singleton pattern to optimize the connections
 **/
 
 class dbConn{
 
  //Singleton Pattern variable
  protected static $db;
 
  /**
   * Default constructor.
   * @params string (host, database, user, password)
  */
  private function __construct($host = 'localhost',$db = 'olapictest',$usr = 'root',$pass = '') {
    try {
      self::$db = new PDO('mysql:host='.$host.';dbname='.$db.'', $usr, $pass);
      self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	} catch (PDOException $e) { 
	    die("DB CONNECTION ERROR: " . $e->getMessage());
    }
  }
 
  //Getter
  //Access to the instance or create it in the first call.
  public static function getConnection() {
    if (!self::$db) {
      new dbConn();  //new connection object.
    return self::$db;
  }
 }
}
?>
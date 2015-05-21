<?php
/**
 * Instagram DBHandler class
 * @author Ariel Gonzalo Romero
 * @since 2015-05-19
 **/
include ('DB_PDO.php');
include ('MediaDB.php');

class InstagramDBHandler
{
	//Private DB Instance
	private $_db;

	//Look if the media is cached on DB
	public function getMedia($id){
      try{
		$_db = dbConn::getConnection();
        $rs = $_db->prepare('Select * from MEDIA_ELEMENTS where id ='.$id);		  
		$rs->execute();		  
		if ($rs->rowCount() == 1){
		  $row  = $rs->fetch();
		  if ($row['timeout'] <= time()){ 
		    //DB object is up to date
		    $obj = MediaDB::newWithLocation($row['lat'],$row['long'],$row['country'],$row['state'],$row['place'],$row['fclName']);
            $obj->setId($row['id']);
            $obj->setTags($row['tags']);
            return $obj;
		  }
		  else { 
		    //the DB object is too old
			$obj = new MediaDB;
			$obj->setId(0);
	        return  $obj; 
		  }
		} else {
  	      //the DB object doesn't exists
		  $obj = new MediaDB;
		  $obj->setId(1);
	      return  $obj; 
		}
      } catch (Exception $e){
		 //DB Error 
        $obj = new MediaDB;
		$obj->setId(-1);
	    return  $obj; 
	  }
	}
	/**
	* Inserts media DB Object into database
	* PARAMS ARRAY [id, timeout, lat, long, contry, state, place, fclname]
	* Returns rowsaffected or -1 when error occurs
	*/
	public function insertMedia($media){
	  if ((is_array($media)) && (sizeof($media) = 8)){
		if (! $this->DeleteMedia($media['id']))
		  return -1;
		try{
  		  $_db = dbConn::getConnection();
		  $sql = 'INSERT INTO media_elements(id, timeout, lat, long, contry, state, place, fclname) ';
		  $sql .= 'VALUE (:id, :timeout, :lat, :long, :contry, :state, :place, :fclname) ';
		  $rs = $_db->prepare($sql);
		  $rs->bindParam(':id',$media['id'], PDO::PARAM_INT);
		  $rs->bindParam(':timeout',$media['timeout'], PDO::PARAM_STR);
		  $rs->bindParam(':lat',$media['lat'], PDO::PARAM_STR);
		  $rs->bindParam(':long',$media['long'], PDO::PARAM_STR);
		  $rs->bindParam(':contry',$media['contry'], PDO::PARAM_STR);
		  $rs->bindParam(':state',$media['state'], PDO::PARAM_STR);
		  $rs->bindParam(':place',$media['place'], PDO::PARAM_STR);
		  $rs->bindParam(':fclname',$media['fclname'], PDO::PARAM_STR);
		  return $rs->execute();
		}
		catch (Exception $e){
		  return -1;
		}
	  } else {
		return 0; //param count not appropiated
	  }
	}
	
	/**
	* Delete media DB Object from database
	* Returns True when success, otherwise False
	*/
	public function deleteMedia($id){
	  try{
  		$_db = dbConn::getConnection();
		$sql = 'DELETE FROM media_elements WHERE id = :id ';
		$rs = $_db->prepare($sql);
		$rs->bindParam(':id',$id, PDO::PARAM_INT);
		return ($rs->execute() > 0);
	  }	catch (Exception $e){
		  return false;
	  }
	}
	
}
?>

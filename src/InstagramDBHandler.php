<?php
/**
 * Instagram DBHandler class
 * @author Ariel Gonzalo Romero
 * @since 2015-05-19
 **/

namespace olapictest;

use DB_PDO;
use MediaDB;

class InstagramDBHandler
{
    //Private DB Instance
    private $db;

    /**
    * Default constructor
    */
    public function __construct()
    {
        $this->db = dbConn::getConnection();
    }

    /**
    * @param string $id with the media ID.
    * @return MediaDB With the cached DB data.
    * This function searches for the media cached on DB, otherwise goes to the API and stores the object in the DB cache 
    * Differents results are handled just in case is necessary in the future for clarify the behavior of the DB object
    */
    public function getMedia($id)
    {
        try {
            $rs = $this->db->prepare('Select * from MEDIA_ELEMENTS where id ='.$id);		  
            $rs->execute();
            
            if ($rs->rowCount() == 1) {
                $row  = $rs->fetch();
                //If DB object is up to date
                if ($row['timeout'] <= time()) {  
                    $obj = new MediaDB($row['lat'],$row['lng'],$row['country'],$row['state'],$row['place'],$row['fclNames']);
                    $obj->setId($row['id']);
                    return $obj;
                } else {
                    //the DB object is too old
                    $obj = new MediaDB('', '', '', '', '', '', '');
                    $obj->setId(0);
                    return  $obj; 
                }
            } else {
                //the DB object doesn't exists
                $obj = new MediaDB('', '', '', '', '', '', '');
                $obj->setId(0);
                return  $obj; 
            }
        } catch (Exception $e) {
            //DB Error 
            //Whe must handle the exception here with some exception handling routine / pattern
            $obj = new MediaDB('', '', '', '', '', '', '');
            $obj->setId(-1);
            return  $obj;
        }
    }

    /**
    * @param array $media with the MediaDB data
    *                                         id,
    *                                         lat,
    *                                         lng,
    *                                         country,
    *                                         state,
    *                                         place,
    *                                         fclnames
    * @return true when success; otherwhise false.
    * This method Inserts media DB Object into database
    */
    public function insertMedia($media)
    {
        //check for the parameters, param array  & length.
        if ((is_array($media)) && (count($media) == 7)) { 
            if (!$this->DeleteMedia($media['id']))
                return false;
            try {
                //We set the default expiration timeout arbitrarily in 1 day
                $statement = $this->_db->prepare("INSERT INTO media_elements(id, timeout, lat, lng, country, state, place, fclnames) 
                                            VALUES(:id,  ADDDATE(CURRENT_TIMESTAMP(), 1), :lat, :lng, :country, :state, :place, :fclnames)");
                $statement->execute(array(
                                            "id"        => $media['id'],
                                            "lat"       => $media['lat'],
                                            "lng"       => $media['lng'],
                                            "country"   => $media['country'],
                                            "state"     => $media['state'],
                                            "place"     => $media['place'],
                                            "fclnames"  => $media['fclnames']
                                            )
                            );
                return true;
            } catch (Exception $e) {
                //Whe must handle the exception here with some exception handling routine / pattern
                return false;
            }
        } else {
            return false; //param count not appropiated
        }
    }

    /**
    * @param string $id with the Media Id
    * @return true when success; otherwhise false.
    * Delete media DB Object from database
    */
    public function deleteMedia($id) 
    {
        try {
            $sql = "DELETE FROM media_elements WHERE id = :id ";
            $rs  = $this->db->prepare($sql);
            $rs->bindParam(':id',$id, PDO::PARAM_INT);
            $rs->execute();
            return true;
        } catch (Exception $e) {
            //Whe must handle the exception here with some exception handling routine / pattern
            return false;
        }
    }
}
?>
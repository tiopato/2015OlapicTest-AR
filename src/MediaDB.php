<?php
/**
 * MediaDB class (this is an sample approach to use of a repository pattern.)
 * @author Ariel Gonzalo Romero
 * @since 2015-05-19
 * There will be a Fake 2 overloaded constructors in order to make easier the location data loading
 **/

class LocationData
{
	public $lat;
	public $long;
	public $country;
	public $state;
	public $place;
	public $fclName;
}
 
class MediaDB
{
	//Universal id
  	private $_id;
	
	//Geo information
	private $_geoData;
	private $_tags;
	
    //Default constructor
    public function __construct(){ $this->_geoData = new LocationData; }
	
	//Pseudo Constructor with data
	//returns a instance of an object filled with data
	public static function newWithLocation($lat, $long, $country, $state, $place, $fclname){
      $obj = new MediaDB(); 		
	  $obj->setGeoData($lat, $long, $country, $state, $place, $fclname); 
	  return $obj;
	}
	
	//Setters and Getters
	//GeoData
	public function setGeoData($lat, $long, $country, $state, $place, $fclname){
	  $this->_geoData->lat = $lat;
	  $this->_geoData->long = $long;
	  $this->_geoData->country = $country;
	  $this->_geoData->state = $state;
	  $this->_geoData->place = $place;
	  $this->_geoData->fclname = $fclname;
	}
	public function getGeoData(){ return $this->_geoData; }
	
	//Media Id
	public function setId($id){ $this->_id = $id; }
	public function getId(){ return $this->_id; }	
	
	//Media Tags
	public function setTags($tags){ $this->_tags = $tags; }
	public function getTags(){ return $this->tags; }	
}

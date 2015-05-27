<?php
/**
 * MediaDB class (this is an sample approach to use of a repository pattern.)
 * @author Ariel Gonzalo Romero
 * @since 2015-05-19
 * There will be a Fake 2 overloaded constructors in order to make easier the location data loading
 **/

class MediaDB
{
	//Universal id
  	private $_id;
	//Latitude
	private $_lat;
	//Longitude
	private $_long;
	//Country where is placed the MediaObject
	private $_country;
	//State where is placed the MediaObject
	private $_state;
	//Place Name where is placed the MediaObject
	private $_place;
	//Denominations of the place of the MediaObject
	private $_fclName;
	

    //Default constructor
    public function __construct(){}
	
	//Pseudo Constructor with data
	//returns a instance of an object filled with data
	public static function newWithLocation($lat, $long, $country, $state, $place, $fclname){
      $obj = new MediaDB(); 		
	  $obj->setGeoData($lat, $long, $country, $state, $place, $fclname); 
	  return $obj;
	}
	
	//Setters and Getters

	/* GeoData */
	public function setGeoData($lat, $long, $country, $state, $place, $fclnames){
		$this->setLat($lat);
		$this->setLong($long);
		$this->setCountry($country);
		$this->setState($state);
		$this->setPlace($place);
		$this->setFclName($fclnames);
	}
	public function getGeoData(){ return $this->_geoData; }
	
	/* Media Id */
	public function setId($id){ $this->_id = $id; }
	public function getId(){ return $this->_id; }	

	/* Latitude */
	public function setLat($lat){ $this->_lat = $lat; }
	public function getLat(){ return $this->_lat; }	

	/* Longitude */
	public function setLong($long){ $this->_long = $long; }
	public function getLong(){ return $this->_long; }	

	/* Country */
	public function setCountry($country){ $this->_country = $country; }
	public function getCountry(){ return $this->_country; }	

	/* State */
	public function setState($state){ $this->_state = $state; }
	public function getState(){ return $this->_state; }	

	/* Name of the place */
	public function setPlace($place){ $this->_place = $place; }
	public function getPlace(){ return $this->_place; }	

	/* fclName for the place */
	public function setFclName($fclName){ $this->_fclName = $fclName; }
	public function getFclName(){ return $this->_fclName; }	

}

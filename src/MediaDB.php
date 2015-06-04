<?php
/**
* MediaDB class (this is an sample approach to use of a repository pattern.)
* @author Ariel Gonzalo Romero
* @since 2015-05-19
*/
namespace olapictest;

class MediaDB
{
    //Universal id
    private $id;
    //Latitude
    private $lat;
    //Longitude
    private $long;
    //Country where is placed the MediaObject
    private $country;
    //State where is placed the MediaObject
    private $state;
    //Place Name where is placed the MediaObject
    private $place;
    //Denominations of the place of the MediaObject
    private $fclName;

    /**
    * Default constructor
    * @param string $lat
    * @param string $long
    * @param string $country
    * @param string $state
    * @param string $place
    * @param string $fclname
    */
    public function __construct($lat, $long, $country, $state, $place, $fclname)
    {
        $this->setGeoData($lat, $long, $country, $state, $place, $fclname); 
    }
	

    /**
    * Getters & Setters
    */
    /**
    * Setter for Geo Data.
    * @param string $lat
    * @param string $long
    * @param string $country
    * @param string $state
    * @param string $place
    * @param string $fclname
    */
    public function setGeoData($lat, $long, $country, $state, $place, $fclnames)
    {
        $this->setLat($lat);
        $this->setLong($long);
        $this->setCountry($country);
        $this->setState($state);
        $this->setPlace($place);
        $this->setFclName($fclnames);
    }

    /** 
    * Getter for Geo Data
    * @return MediaDB object
    */
    public function getGeoData()
    {
        return $this->geoData;
    }

    /**
    * Setter for id
    * @param string $id
    */
    public function setId($id)
    {
        $this->_id = $id;
    }
    /**
    * Getter for id
    * @return string id
    */
    public function getId()
    {
        return $this->id;
    }

    /**
    * Setter for Latitude
    * @param string $lat
    */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }
    /**
    * Getter for Latitude
    * @return lat
    */
    public function getLat()
    {
        return $this->lat;
    }

    /**
    * Setter for Longitude
    * @param string $long
    */
    public function setLong($long)
    {
        $this->long = $long;
    }
    /**
    * Getter for Long
    * @return long
    */
    public function getLong()
    {
        return $this->long;
    }	

    /**
    * Setter for Country
    * @param string $country
    */
    public function setCountry($country)
    {
        $this->country = $country;
    }
    /**
    * Getter for Country
    * @return country
    */
    public function getCountry()
    {
        return $this->country;
    }

    /**
    * Setter for State
    * @param string $state
    */
    public function setState($state)
    {
        $this->state = $state;
    }
    /**
    * Getter for State
    * @return state
    */    
    public function getState()
    {
        return $this->state;
    }

    /**
    * Setter for the Real Name of Place
    * @param string $place
    */
    public function setPlace($place)
    {
        $this->place = $place;
    }
    /**
    * Getter for the Real Name of Place
    * @return place
    */
    public function getPlace()
    {
        return $this->place;
    }

    /**
    * Setter for fclName For the Place (Eg. City, Town, Village)
    * @param $fclName
    */
    public function setFclName($fclName)
    {
        $this->_fclName=$fclName;
    }
    /**
    * Getter for for fclName For the Place (
    * @return fclName
    */
    public function getFclName()
    {
        return $this->fclName;
    }
}

<?php
/**
 * Instagram Controller class
 * @author Ariel Gonzalo Romero
 * @since 2015-05-18
 **/
 
namespace olapictest;

use InstagramDBHandler;

class InstagramController
{
	const DB_ERROR = 200;
	const INSTAGRAM_SERVICE_ERROR = 300;
	const GEOLOCATION_SERVICE_ERROR = 400;

	const GEONAMES_API = "http://api.geonames.org/findNearbyPlaceNameJSON";
	private $instagramClient;
	private $dbHandler;

	/**
	* Default constructor.
	* @param array|string $config Instagram configuration data (key,secret,callback)
	*/
	public function __construct($config)
	{
		$this->_instagramClient = new Instagram($config);
	}

	//Public Metods

	/**
	* Get Media	
	* @param string $id with the Media ID to be proccessed
	* @return JSON object filled with the Media and Geo positioning information.
	*/
    public function getMedia($id)
    {
        //Set the default status code, error type and message
        $respValues = array(
                            'code'          => 200,
                            'error_type'    => "",
                            'error_message' => "",
                            'data'          => ""
        );

            //Declaring an empty array to be filled with the response or be blank if something is wrong
            $arr = array(
                        'id'        => 0, 
                        'location'  => array (
                                            'geopoint' => array(
                                                            'latitude'  => 0, 
                                                            'longitude' => 0
                        ),
                        'extra_data'=> array(
                                            'country'   => '',
                                            'state'     => '',
                                            'place'     => '',
                                            'fclnames'  => ''
                        )
                    )
            ); 

        $this->_dbHandler = new InstagramDBHandler();
        $obj = $this->_dbHandler->getMedia($id);
        //If object is in the DB and is not expired yet.
        if ($obj->getId() > 1) {
            $arr['id']          = $obj->getId();
            $arr['location']    = array (
                                        'geopoint'      => array(
                                                                'latitude'  => $obj->getLat(), 
                                                                'longitude' => $obj->getLong()
                                        ),
                                        'extra_data'    => array(
                                                                'country'   => $obj->getCountry(),
                                                                'state'     => $obj->getState(),
                                                                'place'     => $obj->getPlace(),
                                                                'fclnames'  => $obj->getFclname()
                                        )
                                );
            $respValues['data'] = $arr;
            return json_encode($respValues);
        } else { //If it is expired or not in the DB
            //we must use the API to search for the object
            try 
            {
                //Going to instagram to search for media object.
                $client             = new GuzzleHttp\Client();
                $client->setDefaultOption('verify', false);
                $response           = $client->get($this->_instagramClient->getmediaUrl($id));
                $respValues['code'] =  $response->getStatusCode();
                
                if (($respValues['code'] == 200) 
                && ($response->getHeader('Content-Length') > 0)) {
                    $arr['id']  = $id;
                    $data       = json_decode($response->getBody());
                    $lat        = $data->data->location->latitude;
                    $lng        = $data->data->location->longitude;

                    //Getting extra intormation from location web service
                    $geoClient          = new GuzzleHttp\Client();
                    $geoResp            = $geoClient->get(InstagramController::GEONAMES_API."?lat=".$lat."&lng=".$lng."&username=tiopato");
                    $respValues['code'] = $geoResp->getStatusCode();
                    
                    if ($respValues['code'] == 200) {
                        $geoData            = json_decode($geoResp->getBody());
                        $arr['location']    = array (
                                                    'geopoint'  => array(
                                                                        'latitude'  => $lat,
                                                                        'longitude' => $lng
                                                    ),
                                                    'extra_data'=> array(
                                                                        'country'   => $geoData->geonames[0]->countryName,
                                                                        'state'     => $geoData->geonames[0]->adminName1,
                                                                        'place'     => $geoData->geonames[0]->name,
                                                                        'fclnames'  => $geoData->geonames[0]->fclName
                                                    )
                                            );
				 
                        if ( !$this->_dbHandler->insertMedia(array(
                                                                'id'        => $id,
                                                                'lat'       => $lat,
                                                                'lng'       => $lng,
                                                                'country'   => $geoData->geonames[0]->countryName,
                                                                'state'     => $geoData->geonames[0]->adminName1,
                                                                'place'     => $geoData->geonames[0]->name,
                                                                'fclnames'  => $geoData->geonames[0]->fclName
                                                                ))
                                                                ) {
                            throw new Exception("Something goes wrong storin data in the DB.",InstagramController::DB_ERROR);
                        }
                    } else {
                        $respValues['error_message'] = $geoResp->getMessage();
                    }
                } else {
                    $respValues['error_message'] = $geoResp->getMessage();
                }
            }
            catch (Exception $e) {
                //Whe must handle the exception here with some exception handling routine / pattern		
                $respValues['code'] = 500;
                $respValues['error_message'] = $e->getMessage();
            }

            $respValues['data'] = $arr;
            return json_encode($respValues);
        }
    }
}
?>
<?php

/*
 * Instagram API class
 * @author Ariel Romero
 * This class handles the generation of the URLs needed in the OAuth protocol
 */
class Instagram
{
    /* The API base URL. */
    const API_URL = 'https://api.instagram.com/v1/';

    /* The API OAuth URL. */
    const API_OAUTH_URL = 'https://api.instagram.com/oauth/authorize';

    /* The OAuth token URL. */
    const API_OAUTH_TOKEN_URL = 'https://api.instagram.com/oauth/access_token';

    private $_apikey;
    private $_apisecret;
    private $_callbackurl;
    private $_accesstoken;

    /*
     * Default constructor.
     * @param array|string $config Instagram configuration data
     */
    public function __construct($config)
    {
        if (is_array($config)) {
            // if you want to access user data
            $this->setApiKey($config['apiKey']);
            $this->setApiSecret($config['apiSecret']);
            $this->setApiCallback($config['apiCallback']);
			$this->setAccessToken($config['accessToken']);
        } else {
			//Whe must handle the exception here with some exception handling routine / pattern
            throw new Exception('Error: __construct() - Configuration data is missing.', 100);
        }
    }
	
	//In case when the access token is expired, we must login again.
    public function getLoginUrl() {
        return self::API_OAUTH_URL . '?client_id=' . $this->getApiKey() . '&redirect_uri=' . urlencode($this->getApiCallback()) . '&scope=basic&response_type=code';
    }
	
	//Part of the autentication protocol, we must post with this header uin one of the steps.
    public function getToken($code)
    {
        $apiData = array(
            'grant_type' => 'authorization_code',
            'client_id' => $this->getApiKey(),
            'client_secret' => $this->getApiSecret(),
            'redirect_uri' => $this->getApiCallback(),
            'code' => $code
        );
        return self::API_OAUTH_TOKEN_URL;
    }

	//Returns the media URL
    public function getMediaUrl($id)
    {
        return self::API_URL.'media/' .  (string)$id.'?access_token='. $this->getAccessToken();
    }
	
    //Setters and Getters

	/* Access Token */
    public function setAccessToken($data){
        $token = is_object($data) ? $data->access_token : $data;
        $this->_accesstoken = $token;
    }
    public function getAccessToken(){ return $this->_accesstoken; }

    /* API-key */
    public function setApiKey($apiKey){ $this->_apikey = $apiKey; }
    public function getApiKey(){ return $this->_apikey; }

    /* API Secret */
    public function setApiSecret($apiSecret){ $this->_apisecret = $apiSecret; }
    public function getApiSecret(){ return $this->_apisecret; }

    /* API Callback URL */
    public function setApiCallback($apiCallback){ $this->_callbackurl = $apiCallback; }
    public function getApiCallback(){ return $this->_callbackurl; }	
}
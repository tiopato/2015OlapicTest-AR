<?php
/**
 * Instagram API class
 * @author Ariel Romero
 * @since 2015-05-20
 * This class handles the generation of the URLs needed in the OAuth protocol
 */

namespace olapictest;

class Instagram
{
    // The API base URL
    const API_URL = 'https://api.instagram.com/v1/';
    // The API OAuth URL
    const API_OAUTH_URL = 'https://api.instagram.com/oauth/authorize';
    // The OAuth token URL
    const API_OAUTH_TOKEN_URL = 'https://api.instagram.com/oauth/access_token';

    //API key
    private $apikey;
    //API secret
    private $apisecret;
    //API callbackUrl
    private $callbackurl;
    //AccesToken
    private $accesstoken;

    /**
    * Default constructor.
    * @param array of string $config with Instagram configuration data such as
    *                               apiKey,
    *                               apiSecret, 
    *                               apiCallback,
    *                               accessToken
    * @throws Exception (If configuration data is missing.) 
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

    /**
    * Returns the URL to make the first step of OAuth
    * @return string URL
    */
    public function getLoginUrl()
    {
        return self::API_OAUTH_URL . '?client_id=' . $this->getApiKey() . '&redirect_uri=' 
                    . urlencode($this->getApiCallback()) . '&scope=basic&response_type=code';
    }

    /**
    * As a part of the autentication protocol, we must post with this header in one of the steps.
    * This method should be prepared in order to make the call with the appropriate parameters POS established
    * @param string $code 
    * @return  API_OAUTH_TOKEN_URL constant.
    */
    public function getToken($code)
    {
        $apiData = array(
                        'grant_type'    => 'authorization_code',
                        'client_id'     => $this->getApiKey(),
                        'client_secret' => $this->getApiSecret(),
                        'redirect_uri'  => $this->getApiCallback(),
                        'code'          => $code
        );
        return self::API_OAUTH_TOKEN_URL;
    }

    /**
    * Returns the media URL
    * @param string $id
    * @return The URL ready to be implemented in the REST client used in upper tier
    */
    public function getMediaUrl($id)
    {
        return self::API_URL.'media/' .  (string)$id.'?access_token='. $this->getAccessToken();
    }

    /**
    * Getters & Setters
    */
    /**
    * Setter for Acces Token
    * @param string $data
    */
    public function setAccessToken($data)
    {
        $token              = is_object($data) ? $data->access_token : $data;
        $this->_accesstoken = $token;
    }

    /**
    * Getter for  Acces Token
    * @return 
    */
    public function getAccessToken()
    {
        return $this->accesstoken;
    }

    /**
    * Setter for API-key
    * @param string 
    */
    public function setApiKey($apiKey)
    {
        $this->apikey = $apiKey;
    }
    /**
    * Getter for API-key
    * @return apikey
    */
    public function getApiKey()
    {
        return $this->apikey;
    }

    /**
    * Setter for API Secret
    * @param string apiSecret
    */
    public function setApiSecret($apiSecret)
    {
        $this->apisecret = $apiSecret;
    }
    /**
    * Getter for API Secret
    * @return apisecret
    */
    public function getApiSecret()
    {
        return $this->apisecret;
    }

    /**
    * Setter for API Callback URL
    * @param string $apiCallback
    */
    public function setApiCallback($apiCallback)
    {
        $this->callbackurl = $apiCallback;
    }
    /**
    * Getter for API Callback URL
    * @return callbackurl
    */
    public function getApiCallback()
    {
        return $this->callbackurl;
    }
}
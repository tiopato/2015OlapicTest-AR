# 2015OlapicTest-AR
- This is the readme File por the Olapic Test for Ariel Romero.
- All considerations regarding this proyect will be here.

Section <Requirements>  
//****************************************//
  Media Location Information

(A) Objective
  
    Build a service which retrieves all the information you can about the Location of a photo or video uploaded to a social network.
    We define Location as a combination of a GeoPoint (latitude and longitude), a Place (Facebook, Foursquare, Instagram or Yelp) and all its related information (country, state, city, neighborhood, etc)

    Specific Case
      In this case, we will use an Instagram media id from which we need the data. And the service should be a facing the internet using a Rest API.
      We expect an API endpoint which we could hit with an instagram media id as parameter and the response should be all the possible information about location you can gather from that object.

  (A-1) Example:
    Request:GET /media/123456
    Response:
      STATUS 200
      {
          "id": 123456,
          "location": {
          "geopoint": {
          "latitude": 42.277,
          "longitude": -71.9256
          }
        }
      }
    
(B) Conditions
    + The project should be developed using PHP 5.4+
    + If necessary, you can use any web framework of your choice, We recommend Silex
    + You can use the data store solution of your choice if you need one
    + The full project should be correctly revisioned using GIT. That GIT repository should be accesible by us (publicly or privately) on GitHub or BitBucket.
    + You don’t need to serve the project to the internet but it should be testeable locally using the php built-in webserver or similar solution with the proper documentation on how to do it
    + Unit Tests are a big plus!
    + All added value you can give to the original idea is highly appreciated


<?php 
chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

include '/src/InstagramController.php';
include '/src/MyInstagram.php';

$config = array('apiKey' => '951a82705ba84fbe9aa3d33ddec50d24',
				'apiSecret'=> '40a618805efc4490a65ee83461caaa55', 
				'apiCallback' => 'http://localhost/Olapictest/src/Processing.php',
				'accessToken' => '35603968.951a827.a8f711f3c0ab48a09fe408f5ee07f188');

$inst = new InstagramController($config);
print_r($inst->getMedia('989218074031794421'));

?>


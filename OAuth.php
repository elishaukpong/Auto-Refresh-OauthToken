<?php

$restreamConfig = $config['restream'];

$provider =  new \League\OAuth2\Client\Provider\GenericProvider([
				'clientId'                => $restreamConfig['clientId'],    
				'clientSecret'            => $restreamConfig['clientSecret'],   
				'redirectUri'             =>  $restreamConfig['redirectUri'],
				'urlAuthorize'            => $restreamConfig['urlAuthorize'],
				'urlAccessToken'          => $restreamConfig['urlAccessToken'],
				'urlResourceOwnerDetails' => $restreamConfig['urlResourceOwnerDetails'],
			]);


$authTokens = getAuthTokenFromDB($conn);

return $provider;
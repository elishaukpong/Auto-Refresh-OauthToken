<?php


function refreshToken(array $data, $refresh_token)
{
    $post_data = [
        'grant_type' => 'refresh_token',
        'refresh_token' => $refresh_token
    ];

    $curl = curl_init('https://api.restream.io/oauth/token');
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "{$data['clientId']}:{$data['clientSecret']}"); //Your credentials goes here
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 

    $curl_response = curl_exec($curl);
    $response = json_decode($curl_response);
    curl_close($curl);

    return $response;

}

function tokenInDatabase(){
	global $authTokens;
	return count($authTokens) > 0 ? true :false;
}

function tokenNearExpiry($tokenExpirationTime){
	$currentTimeInEpoch = date_timestamp_get(date_create());
	
	return ($tokenExpirationTime - $currentTimeInEpoch) < 600 ? true : false;
}

function getParametersFrom($token){
	return [
		'access_token' => $token->getToken(),
		'refresh_token' => $token->getRefreshToken(),
		'token_expire_time' => $token->getExpires()
	];
}
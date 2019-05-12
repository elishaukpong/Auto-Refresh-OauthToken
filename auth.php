<?php

require_once('bootstrap.php');

//check if there is token in database
if(tokenInDatabase())
{
	$parameters = [];
	$parameters['token'] = $authTokens[0]->access_token;
	$parameters['refresh_token'] = $authTokens[0]->refresh_token;
	$parameters['token_expiration_time'] = $authTokens[0]->token_expire_time;
	
	
	if(tokenNearExpiry($parameters['token_expiration_time']))
	{
		$accessToken = new League\OAuth2\Client\Token\AccessToken(
				(array)refreshToken($restreamConfig, $parameters['refresh_token'])
		);
		
		$parameters = getParametersFrom($accessToken);
		
		update($conn, $parameters);
		
		return var_dump($parameters);
		
	}
	return var_dump($parameters);
	
}else{
	
	if (!isset($_GET['code'])) {

		// Fetch the authorization URL from the provider; this returns the
		// urlAuthorize option and generates and applies any necessary parameters
		// (e.g. state).
		$authorizationUrl = $provider->getAuthorizationUrl();

		// Get the state generated for you and store it to the session.
		$_SESSION['oauth2state'] = $provider->getState();

		// Redirect the user to the authorization URL.
		header('Location: ' . $authorizationUrl);
		exit;

	// Check given state against previously stored one to mitigate CSRF attack
	} elseif (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {

		if (isset($_SESSION['oauth2state'])) {
			unset($_SESSION['oauth2state']);
		}

		exit('Invalid state');

	} else {

		try {

			// Try to get an access token using the authorization code grant.
		
			$accessToken = $provider->getAccessToken('authorization_code', [
				'code' => $_GET['code']
			]);
			
			
			
			// prepare for database insert

			$parameters = getParametersFrom($accessToken);

			insert($conn, $parameters);
			
			return var_dump($parameters);

			// Using the access token, we may look up details about the
			// resource owner.
			//$resourceOwner = $provider->getResourceOwner($accessToken);

			//var_export($resourceOwner->toArray());


			// The provider provides a way to get an authenticated API request for
			// the service, using the access token; it returns an object conforming
			// to Psr\Http\Message\RequestInterface.
			$request = $provider->getAuthenticatedRequest(
				'GET',
				'http://brentertainment.com/oauth2/lockdin/resource',
				$accessToken
			);

		} catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

			// Failed to get the access token or user details.
			exit($e->getMessage());

		}

	}


}


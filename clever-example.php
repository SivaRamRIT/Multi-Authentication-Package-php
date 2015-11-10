<?php
session_start();
/**
 * This script demonstrates Clever Instant Login, using OAuth 2.0 for token acquistion & request authentication.
 */

// By default, stop on all errors. In a production application, you may want to use only E_WARNING or otherwise silence with ~E_ALL
error_reporting(E_ALL);

// Handle incoming requests if we're running in a web server context
if($_SERVER && array_key_exists('REQUEST_URI', $_SERVER)) {
  process_incoming_requests($_SERVER['REQUEST_URI'], set_options());
}

/**
 * Prepares options common to interacting with Clever's authentication & API
 *
 * @param   array $override_options  Options to oveverride from defaults
 * @throws  Exception if configuration options are not adequately met
 * @return  array $results           Options for use in Clever API requests
 */
function set_options(array $override_options = NULL) {
  $options = array(
    // Obtain your Client ID and secret from your Clever developer dashboard at https://account.clever.com/partner/applications
    'client_id' => 'xxxxxxxxxxxxxxx',
    'client_secret' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    'clever_redirect_base' => 'http://localhost:2587',
    'clever_oauth_base' => 'https://clever.com/oauth',
    'clever_api_base' => 'https://api.clever.com',
  );
  if (isset($override_options)) {
    array_merge($options, $override_options);
  }

  $options['clever_oauth_tokens_url'] = $options['clever_oauth_base'] . "/tokens";
  $options['clever_oauth_authorize_url'] = $options['clever_oauth_base'] . "/authorize";
  $options['clever_api_me_url'] = $options['clever_api_base'] . '/me';
 // $options['clever_api_student_url'] = $options['clever_api_base'] . '/student';

  // Clever redirect URIs must be preregistered on your developer dashboard.
  // If using the default PORT set above, make sure to register "http://localhost:2587/oauth"
  $options['client_redirect_url'] = $options['clever_redirect_base'] . "/oauth";
  if (!empty($options['client_id']) && !empty($options['client_secret']) && !empty($options['clever_redirect_base'])) {
    return $options;
  } else {
    throw new Exception("Cannot communicate with Clever without configuration.");
  }
}

/**
 * Services requests based on the incoming request path
 *
 * @param   string $incoming_request_uri  The URI being visited in this script
 * @param   array  $options               Options used for Clever API requests
 */
function process_incoming_requests($incoming_request_uri, array $options) {
  if(preg_match('/oauth/', $incoming_request_uri)) {
    try {
      $me = process_client_redirect($_GET['code'], $options);
   
    
       if($me['type'] == 'student')
       {
          
           $type = $me['type'];
           $uri = $me['links'][1]['uri'];
          
           $student_info = process_client_redirect($_GET['code'], $options, $type, $uri);  //get full student info
           //Session::forget('bearer_token'); 
		   unset($_SESSION['bearer_token']);
		   
		   print_r($student_info);
           
       }
         if($me['type'] == 'teacher')
       {
          
           $type = $me['type'];
           $uri = $me['links'][1]['uri'];
          
           $teacher_info = process_client_redirect($_GET['code'], $options, $type, $uri);   //get full teacher info
           //Session::forget('bearer_token');
		   unset($_SESSION['bearer_token']);
		   
		   print_r($student_info);
       }
    } catch (Exception $e) {
      echo("<p>Something exceptional happened while interacting with Clever.");
      echo("<pre>");
      print_r($e);
      echo("</pre>");
    }
  } else {
    // Our home page route will create a Clever Instant Login button for users
    $sign_in_link = generate_sign_in_with_clever_link($options);
    echo("<h3>clever_oauth_examples: Login!</h3>");
    echo('<p>' . $sign_in_link . '</p>');
    echo("<p>Ready to handle OAuth 2.0 client redirects on {$options['client_redirect_url']}.</p>");
  }
}

/**
 * Processes incoming requests to our $client_redirect
 * 1. Exchanges incoming code parameter for a bearer token
 * 2. Uses bearer token in a request to Clever's "/me" API resource
 * @param   string $code         OAuth 2.0 exchange code received when our  OAuth redirect was triggered
 * @param   array  $options      Options used for Clever API requests
 * @return  array  $me_response  Hash of Clever's response when identifying a bearer token's owner
 */
function process_client_redirect($code, array $options, $type = null, $uri = null) {


  if($type == 'student') {

    $bearer_token = Session::get('bearer_token');
    $student_uri = $uri;
    $type = 'student';
    $request_options = array('method' => 'GET', 'bearer_token' => $bearer_token);
    $student_response = retrieve_me_response_for_bearer_token($bearer_token, $options, $type, $student_uri);
   
    return $student_response;
  }
  elseif($type == 'teacher') {

    $bearer_token = Session::get('bearer_token');
    $teacher_uri = $uri;
    $type = 'teacher';
    $request_options = array('method' => 'GET', 'bearer_token' => $bearer_token);
    $teacher_response = retrieve_me_response_for_bearer_token($bearer_token, $options, $type, $teacher_uri);
   
     return $teacher_response;

  }
  else {

    $bearer_token = exchange_code_for_bearer_token($code, $options);
    //Session::put('bearer_token', $bearer_token);  //Store it in the session to use it later for retrieving full student or teacher info
	$_SESSION['bearer_token'] = $bearer_token;  
    $request_options = array('method' => 'GET', 'bearer_token' => $bearer_token);
    $me_response = retrieve_me_response_for_bearer_token($bearer_token, $options);

    return $me_response;
  }
}


/**
 * Exchanges a $code value received in a $client_redirect for a bearer token
 * @param   string $code          OAuth 2.0 exchange code received when our OAuth redirect was triggered
 * @param   array  $options       Options used for Clever API requests
 * @throws  Exception if the bearer token cannot be retrieved
 * @return  string $bearer_token  The string value of a user's OAuth 2.0 access token
 */
function exchange_code_for_bearer_token($code, array $options) {
  $data = array('code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $options['client_redirect_url']);
  $request_options = array('method' => 'POST', 'data' => $data);
  $response = request_from_clever($options['clever_oauth_tokens_url'], $request_options, $options);
  // Evaluate if the response is successful
  if ($response && $response['response_code'] && $response['response_code'] == '200') {
    $bearer_token = $response['response']['access_token'];
    return $bearer_token;
  } else {
    // Handle condition when $code cannot be exchanged for bearer token from Clever
    throw new Exception("Cannot retrieve bearer token.");
  }
}

/**
 * Uses the specified bearer token to retrieve the /me response for the user
 * @param   string $bearer_token   The string value of a user's OAuth 2.0 access token
 * @param   array  $options        Options used for Clever API requests
 * @throws  Exception if the /me API response cannot be retrieved
 * @return  array $oauth_response  Hash of Clever's response when identifying a bearer token's owner
 */
function retrieve_me_response_for_bearer_token($bearer_token, array $options, $type = null, $uri = null) {

   if($type == 'student' || $type == 'teacher') {
        
     $full_uri = 'https://api.clever.com' . $uri;
   }
   else {
     $full_uri = $options['clever_api_me_url'];
   }

  
    $request_options = array('method' => 'GET', 'bearer_token' => $bearer_token);
    $response = request_from_clever($full_uri, $request_options, $options);
    // Evaluate if the response is successful
    if ($response && $response['response_code'] && $response['response_code'] == '200') {
      $oauth_response = $response['response'];
      return $oauth_response;
    } else {
      // Handle condition when /me response cannot be retrieved for bearer token
      throw new Exception("Could not retrieve /me response for bearer token.");
    }
}



/**
 * General-purpose HTTP wrapper for working with the Clever API
 * @param   string $url                 The fully-qualified URL that the request will be issued to
 * @param   array  $request_options      Hash of options pertinent to the specific request
 * @param   array  $clever_options       Hash of options more generally associated with Clever API requests
 * @throws  Exception when the HTTP library, cURL, cannot issue the request
 * @return  array  $normalized_response  A structured hash with pertinent response & request details
 */
function request_from_clever($url, array $request_options, array $clever_options) {
  $ch = curl_init($url);
  $request_headers = array('Accept: application/json');
  if ($request_options && array_key_exists('bearer_token', $request_options)) {
    $auth_header = 'Authorization: Bearer ' . $request_options['bearer_token'];
    $request_headers[] = $auth_header;
  } else {
    // When we don't have a bearer token, assume we're performing client auth.
    curl_setopt($ch, CURLOPT_USERPWD, $clever_options['client_id'] . ':' . $clever_options['client_secret']);
  }
  if ($request_options && array_key_exists('method', $request_options) && $request_options['method'] == 'POST') {
    curl_setopt($ch, CURLOPT_POST, 1);
    if ($request_options['data']) {
      curl_setopt($ch, CURLOPT_POSTFIELDS, $request_options['data']);
    }
  }
  // Set prepared HTTP headers
  curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $raw_response = curl_exec($ch);
  $parsed_response = json_decode($raw_response, true);
  $curl_info = curl_getinfo($ch);

  // Provide the HTTP response code for easy error handling.
  $response_code = $curl_info['http_code'];

  if($curl_error = curl_errno($ch)) {
    $error_message = curl_strerror($curl_error);
    throw new Exception("cURL failure #{$curl_error}: {$error_message}");
  }

  // Prepare the parsed and raw response for further use.
  $normalized_response = array('response_code' => $response_code, 'response' => $parsed_response, 'raw_response' => $raw_response, 'curl_info' => $curl_info);
  return $normalized_response;
}

/**
 * Generates a "Sign in with Clever" instant login URL based on the application's current district context
 * @param   array  $options  Options used for Clever API requests
 * @return  string $url      A URL representing the destination for a Sign in with Clever button
 */
function generate_sign_in_with_clever_url(array $options) {
  $request_params = array(
    'response_type' => 'code',
    'redirect_uri' => $options['client_redirect_url'],
    'client_id' => $options['client_id'],
    'scope' => 'read:user_id read:teachers read:students'
  );
  $querystring = http_build_query($request_params);
  $url = $options['clever_oauth_authorize_url'] . '?' . $querystring;
  return $url;
}

/**
 * Generates a HTML "Sign in with Clever" instant login link
 * @param   array  $options  Options used for Clever API requests
 * @return  string $html     A HTML anchor tag linking to the destination for a Sign in with Clever button
*/
function generate_sign_in_with_clever_link(array $options) {
  $html = "<a href='" . generate_sign_in_with_clever_url($options) . "'><img src='http://assets.clever.com/sign-in-with-clever/sign-in-with-clever-full.png'/></a>";
  return $html;
}

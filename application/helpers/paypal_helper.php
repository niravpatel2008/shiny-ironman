<?php
class wp_paypal_gateway
{
    /**
     * PayPal API Version
     * @string
     */
    public $version;

    /**
     * PayPal account username
     * @string
     */
    public $user;

    /**
     * PayPal account password
     * @string
     */
    public $password;

    /**
     * PayPal account signature
     * @string
     */
    public $signature;

    /**
     * Period of time (in seconds) after which the connection ends
     * @integer
     */
    public $time_out = 60;

    /**
     * Requires SSL Verification
     * @boolean
     */
    public $ssl_verify;

    /**
     * PayPal API Server
     * @string
     */
    private $server;

    /**
     * PayPal API Redirect URL
     * @string
     */
    private $redirect_url;

    /**
     * Real world PayPal API Server
     * @string
     */
    private $real_server = 'https://api-3t.paypal.com/nvp';

    /**
     * Read world PayPal redirect URL
     * @string
     */
    private $real_redirect_url = 'https://www.paypal.com/cgi-bin/webscr';

    /**
     * Sandbox PayPal Server
     * @string
     */
    private $sandbox_server = 'https://api-3t.sandbox.paypal.com/nvp';

    /**
     * Sandbox PayPal redirect URL
     * @string
     */
    private $sandbox_redirect_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

    /**
     * Array representing the supported short-terms
     * @array
     */
    private $short_term = array(
        'amount' => 'PAYMENTREQUEST_0_AMT',
        'currency_code' => 'PAYMENTREQUEST_0_CURRENCYCODE',
        'return_url' => 'RETURNURL',
        'cancel_url' => 'CANCELURL',
        'payment_action' => 'PAYMENTREQUEST_0_PAYMENTACTION',
        'token' => 'TOKEN',
        'payer_id' => 'PAYERID'
    );

    /**
     * When something goes wrong, the debug_info variable will be set
     * with a string, array, or object explaining the problem
     * @mixed
     */
    public $debug_info;

    /**
     * Saves the full response once a request succeed
     * @mixed
     */
    public $full_response = false;

    /**
     * Creates a new PayPal gateway object
     * @param boolean $sandbox Set to true if you want to enable the Sandbox mode
     */
    public function __construct($sandbox = false)
    {
        // Set the Server and Redirect URL
        if ($sandbox) {
            $this->server = $this->sandbox_server;
            $this->redirect_url = $this->sandbox_redirect_url;
        } else {
            $this->server = $this->real_server;
            $this->redirect_url = $this->real_redirect_url;
        }

		// Common Parameters
		$this->version = PAYPAL_API_VERSION;
		$this->user = PAYPAL_API_USER;
		$this->password = PAYPAL_API_PASSWORD;
		$this->signature = PAYPAL_API_SIGNATURE;

        // Set the SSL Verification
        $this->ssl_verify = false;
    }

    /**
     * Executes a setExpressCheckout command
     * @param array $param
     * @return boolean
     */
    public function setExpressCheckout($param)
    {
        return $this->requestExpressCheckout('SetExpressCheckout', $param);
    }

    /**
     * Executes a getExpressCheckout command
     * @param array $param
     * @return boolean
     */
    public function getExpressCheckout($param)
    {
        return $this->requestExpressCheckout('GetExpressCheckoutDetails', $param);
    }

    /**
     * Executes a doExpressCheckout command
     * @param array $param
     * @return boolean
     */
    public function doExpressCheckout($param)
    {
        return $this->requestExpressCheckout('DoExpressCheckoutPayment', $param);
    }

    /**
     * @param string $type
     * @param array $param
     * @return boolean Specifies if the request is successful and the response property
     *                 is filled
     */
    private function requestExpressCheckout($type, $param)
    {
        // Construct the request array
        $param = $this->replace_short_terms($param);
        $request = $this->build_request($type, $param);

        // Makes the HTTP request
		//print_r($request);exit;
		
        //$response = wp_remote_post($this->server, $request);
		//print_r($request["body"]);exit;
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL,             $this->server);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER,  true);
		curl_setopt($handle, CURLOPT_POST,            true );
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($handle, CURLOPT_TIMEOUT, $this->time_out);
		curl_setopt($handle, CURLOPT_FOLLOWLOCATION,  true );
		curl_setopt($handle, CURLOPT_POSTFIELDS,      http_build_query($request["body"]));

		$response = curl_exec($handle);
		$response = parse_str($response,$res);
		
		if("SUCCESS" == strtoupper($res["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($res["ACK"]))
        {
			//print_r($res);exit;
			$this->full_response = $res;
			return true;
        }else{
            return false;
        }
    }

    /**
     * Replace the Parameters short terms
     * @param array $param The given parameters array
     * @return array $param
     */
    private function replace_short_terms($param)
    {
        foreach ($this->short_term as $short_term => $long_term)
        {
            if (array_key_exists($short_term, $param)) {
                $param[$long_term] = $param[$short_term];
                unset($param[$short_term]);
            }
        }
        return $param;
    }

    /**
     * Builds the request array from the object, param and type parameters
     * @param string $type
     * @param array $param
     * @return array $body
     */
    private function build_request($type, $param)
    {
        // Request Body
        $body = $param;
        $body['METHOD'] = $type;
        $body['VERSION'] = $this->version;
        $body['USER'] = $this->user;
        $body['PWD'] = $this->password;
        $body['SIGNATURE'] = $this->signature;

        // Request Array
        $request = array(
            'method' => 'POST',
            'body' => $body,
            'timeout' => $this->time_out,
            'sslverify' => $this->ssl_verify
        );

        return $request;
    }

    /**
     * Returns the PayPal Body response
     * @return array $reponse
     */
    public function getResponse()
    {
        if ($this->full_response) {
            //parse_str(urldecode($this->full_response['body']), $output);
            return $this->full_response;
        }
        return false;
    }

    /**
     * Returns the redirect URL
     * @return string $url
     */
    public function getRedirectURL()
    {
        $output = $this->getResponse();
        if ($output['ACK'] === 'Success') {
            $query_data = array(
                'cmd' => '_express-checkout',
                'token' => $output['TOKEN']
            );
            $url = $this->redirect_url . '?' . http_build_query($query_data);
            return $url;
        }
        return false;
    }

    /**
     * Returns the response Token
     * @return string $token
     */
    public function getToken()
    {
        $output = $this->getResponse();
        if ($output['ACK'] === 'Success') {
            return $output['TOKEN'];
        }
        return false;
    }
}
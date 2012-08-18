<?php

class ElqRestRequest 
{
	protected $ch;
	protected $baseUrl;

	/*
	 * Instatiate a new instance of the Rest Client
	 */
	public function __construct($site, $user, $password, $baseUrl)
	{
		$this->baseUrl = $baseUrl;
		$this->ch = curl_init();

		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_USERPWD, ($site . "\\" . $user . ":" . $password)); 
	}

	public function __destruct()
	{
		curl_close($this->ch);
	}

	public function get($url)
	{
		return $this->executeRequest($url, 'GET');
	}	

	public function post($url, $data)
	{
		return $this->executeRequest($url, 'POST', $data);
	}

	public function put($url, $data)
	{
		return $this->executeRequest($url, 'PUT', $data);
	}

	public function delete($url)
	{
		return $this->executeRequest($url, 'DELETE');
	}

	public function executeRequest($url, $method, $body = null)
	{
		// Define the full URL for the request
		$fullUrl = $this->baseUrl . $url;

		// Set cURL options
		curl_setopt($this->ch, CURLOPT_URL, $fullUrl);
		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method);
		
		// Define the body of the request
                $body = (is_array($body)) ? http_build_query($body) : $body;

		if ($body != null) 
		{
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $body);
		}

		// Invoke the request
		$response = curl_exec($this->ch);

		// Return the response
		// todo ; add support for content type (json, xml)	
		return json_decode($response);
	}
}

?>

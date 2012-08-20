<?php

###
# Extension of SoapClient - Eloqua SOAP API
##
class ElqSoapClient extends SoapClient 
{
	public function __construct($wsdl, $username, $password) 
	{
		# WSSE security namespace
		$wsSecurityNS = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";

		# SOAP username and password variables
		$soapVarUser = new SoapVar($username, XSD_STRING, NULL, $wsSecurityNS, NULL, $wsSecurityNS);
		$soapVarPass = new SoapVar($password, XSD_STRING, NULL, $wsSecurityNS, NULL, $wsSecurityNS);

		# WSSE authentication SOAP variables
		$WsAuthentication = new WsAuthentication($soapVarUser, $soapVarPass);
		$soapVarWsAuthentication = new SoapVar($WsAuthentication, SOAP_ENC_OBJECT, NULL, $wsSecurityNS, 'UsernameToken', $wsSecurityNS);

		# WSSE authentication token
		$WsToken = new WsToken($soapVarWsAuthentication);

		# Authentication headers
		$soapVarWsToken = new SoapVar($WsToken, SOAP_ENC_OBJECT, NULL, $wsSecurityNS, 'UsernameToken', $wsSecurityNS);
		$soapVarHeaderVal=new SoapVar($soapVarWsToken, SOAP_ENC_OBJECT, NULL, $wsSecurityNS, 'Security', $wsSecurityNS);
		$soapVarWsHeader = new SoapHeader($wsSecurityNS, 'Security', $soapVarHeaderVal, true);

		# Create client
		parent::__construct($wsdl);
		parent::__setSoapHeaders(array($soapVarWsHeader));
	}
}


###
# Authentication helper class
##
class WsAuthentication 
{
	private $Username;
	private $Password;
 
	function __construct($username, $password)
	{
		$this->Username=$username;
		$this->Password=$password;
	} 
}
 
###
# Web Service Token helper class
##
class WsToken 
{
	private $UsernameToken;
	
	function __construct ($innerVal)
	{
		$this->UsernameToken = $innerVal;
	}
}

?>
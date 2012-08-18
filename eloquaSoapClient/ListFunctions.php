<?php

include ("ElqSoapClient.php");

##
# Sample Code - List SOAP functions
##

# WSDL document
$wsdl = "https://secure.eloqua.com/API/1.2/service.svc?wsdl";
 
# Client Credentials
$username = "CompanyName\Username";
$password = "###########";

# Instantiate a new instance of the Elq Soap client
$client = new ElqSoapClient($wsdl, $username, $password);
 
# List web service methods
try
{
	print_r ($client->__getFunctions());
}
catch (Exception $e)
{
	print ($e->getMessage());
}
 
# Print the response
print_r($response);

?>
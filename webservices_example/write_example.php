<?

/**
 * Webservice in PHP with OpenERP 7.0 using Pear XML-RPC.
 * Example with with the Ideas module.
 * Tested on Debian server with Apache2, PHP5 and PEAR php-xml-rpc 1.5.3
 *
 * Author: Guillaume RIVIERE (C) 2013-2014
 *
 * With the help of:
 *  http://doc.openerp.com/v6.1/developer/12_api.html
 *  http://pear.php.net/package/XML_RPC/docs
 *  http://pear.php.net/manual/en/package.webservices.xml-rpc.api.php
 */

require_once('XML/RPC.php'); // Include PEAR library for XML-RPC
require_once('login.inc.php');
require_once('vars.inc.php');

echo '<html>';
echo '<head><title>Test OpenERP 7.0 webservices</title></head>';
echo '<body>';
echo '<h1>Test OpenERP 7.0 webservices</h1>';

// ================================================
// Login

echo '<h2>Login</h2>';

$uid = login ($HOST, $PORT, $DB, $USER, $PASS, $DEBUG) ;

// ================================================
// Write

echo '<h2>Write example</h2>';

$id = $_GET['id'];
$new_name = $_GET['new_name'];

echo "<p>Trying to edit record with id=$id</p>";

$client = new XML_RPC_Client('/xmlrpc/object', "http://$HOST:$PORT");
$client->setDebug($DEBUG);

$ids = array ( // Ids of the records to edit
    new XML_RPC_Value("$id", 'int'),
);

$structVal = array( // Values to give to the fields of the records
    'name' => new XML_RPC_Value($new_name, 'string'),
);

$msg = new XML_RPC_Message('execute');
$msg->addParam(new XML_RPC_Value($DB, 'string'));
$msg->addParam(new XML_RPC_Value($uid, 'int'));
$msg->addParam(new XML_RPC_Value($PASS, 'string'));
$msg->addParam(new XML_RPC_Value('idea.idea', 'string')); // Name of the relation
$msg->addParam(new XML_RPC_Value('write', 'string'));     // The ORM method
$msg->addParam(new XML_RPC_Value($ids, 'array'));         // List of id of each record to write
$msg->addParam(new XML_RPC_Value($structVal, 'struct'));  // The values to write

$resp = $client->send($msg);

if (!$resp)
  die('Communication error: ' . $client->errstr);
else if ($resp->faultCode()) { // FaultCode seams to be never set by OpenERP 7.0
  echo 'Fault Code: '.$resp->faultCode()."\r\n";
  echo 'Fault Reason: '.$resp->faultString()."\r\n";
  exit(1);
}

$val = $resp->value() ;

if ($val->kindOf() == 'struct') {
  $struct = XML_RPC_decode($val) ;
  if (isset($struct['faultCode'])) // Trick to catch fault code
    echo '<p>FAILURE RESPONSE: '.$struct['faultCode']."</p>\r\n" ;
}
else { // kindOf == 'scalar'
  // Show returned value (should be True)
  echo $val->scalarval();
}

echo '<p><a href="form.html">Back to the form</a></p>';

echo '</body>';
echo '</html>';

?>

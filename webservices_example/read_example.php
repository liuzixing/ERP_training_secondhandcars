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
// Read

echo '<h2>Read example</h2>';

$id1 = $_GET['id1'] ;
$id2 = $_GET['id2'] ;

echo "<p>Trying to read the records with id=$id1 and id=$id2</p>" ;

$client = new XML_RPC_Client('/xmlrpc/object', "http://$HOST:$PORT");
$client->setDebug($DEBUG);

$ids = array ( // Ids of the records to read
  new XML_RPC_Value("$id1", 'int'),
  new XML_RPC_Value("$id2", 'int'),
);

$arrayVal = array( // Fields to return
  new XML_RPC_Value('name', 'string'),
  new XML_RPC_Value('description', 'string'),
);

$msg = new XML_RPC_Message('execute');
$msg->addParam(new XML_RPC_Value($DB, 'string'));
$msg->addParam(new XML_RPC_Value($uid, 'int'));
$msg->addParam(new XML_RPC_Value($PASS, 'string'));
$msg->addParam(new XML_RPC_Value('idea.idea', 'string')); // Name of the relation
$msg->addParam(new XML_RPC_Value('read', 'string'));      // The ORM method
$msg->addParam(new XML_RPC_Value($ids, 'array'));         // List of id of each record to read
$msg->addParam(new XML_RPC_Value($arrayVal, 'array'));    // List of fields to return

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
else { // kindOf ==  array_push($ids, new XML_RPC_Value("$v", 'int')); 'array'
  $a = XML_RPC_decode($val) ;
  // Show each record
  foreach ($a as $ai) {
    // Show id and values (according to selected fields) of the record
    foreach ($ai as $k => $v) {
      echo '<p>value['.$k.'] = '.$v.'</p>';
    }
  }
}

echo '<p><a href="form.html">Back to the form</a></p>';

echo '</body>';
echo '</html>';

?>

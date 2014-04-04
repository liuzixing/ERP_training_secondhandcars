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
// Search

echo '<h2>Engine Search</h2>';

$engine_val = $_GET['engine_val'];

echo '<p>Searching the ids of the engine where the column state equals to '.$state_val.'</p>';

$client = new XML_RPC_Client('/xmlrpc/object', "http://$HOST:$PORT");
$client->setDebug($DEBUG);

$keys = array ( // Search criteria
  new XML_RPC_Value(
    array (
      new XML_RPC_Value('engine', 'string'), // Field name
      new XML_RPC_Value('=', 'string'),     // Operator
      new XML_RPC_Value($engine_val, 'string'), // Value
    ), 'array'),
);

$msg = new XML_RPC_Message('execute');
$msg->addParam(new XML_RPC_Value($DB, 'string'));
$msg->addParam(new XML_RPC_Value($uid, 'int'));
$msg->addParam(new XML_RPC_Value($PASS, 'string'));
$msg->addParam(new XML_RPC_Value('secondhandcars.car', 'string')); // Name of the relation 
$msg->addParam(new XML_RPC_Value('search', 'string'));	  // The ORM method
$msg->addParam(new XML_RPC_Value($keys, 'array'));	  // List of search criteria

$ids = array () ; // Ids of the records to read
  
$arrayVal = array( // Fields to return
  new XML_RPC_Value('immatriculation', 'string'),
  new XML_RPC_Value('price', 'float'),
);

$msg2 = new XML_RPC_Message('execute');
$msg2->addParam(new XML_RPC_Value($DB, 'string'));
$msg2->addParam(new XML_RPC_Value($uid, 'int'));
$msg2->addParam(new XML_RPC_Value($PASS, 'string'));
$msg2->addParam(new XML_RPC_Value('secondhandcars.car', 'string')); // Name of the relation
$msg2->addParam(new XML_RPC_Value('read', 'string'));      // The ORM method
$msg2->addParam(new XML_RPC_Value($ids, 'array'));         // List of id of each record to read
$msg2->addParam(new XML_RPC_Value($arrayVal, 'array'));    // List of fields to return

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
else { // kindOf == 'array'
  $a = XML_RPC_decode($val) ;
  echo '<p>Number of results: '.count($a).'</p>';
  // Show ids of each record matching the criteria
  foreach ($a as $k => $v) {
      $ids[$k] = new XML_RPC_Value("$v", 'int'));
      echo '<p>id['.$k.'] = '.$v.'</p>';
  }
  $resp2 = $client->send($msg2);
  $val2 = $resp2->value();
$a2 = XML_RPC_decode($val2) ;
  // Show each record
  foreach ($a2 as $ai2) {
    // Show id and values (according to selected fields) of the record
    foreach ($ai2 as $k2 => $v2) {
      echo '<p>value['.$k2.'] = '.$v2.'</p>';
    }
  }
}

echo '<p><a href="form.html">Back to the form</a></p>';

echo '</body>';
echo '</html>';

?>

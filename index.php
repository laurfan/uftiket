<?php

$action = $_GET['action'];
$entoken = $_GET['entoken'];

$partner=array();
$data=array();
$var=array(
  'today'=>date('Y-m-d'),
  'date'=>'2017-06-10',
  'flight_id'=>'13673709',
  'ret_date'=>'',
  'ret_flight_id'=>'',
  );
// Pre
if($entoken) {
  load_partner_token();
} else {
  load_partner_data();
}

load_partner_open_data();

$data = array_merge($data, $partner);
$data['output']='json';

// --- end of pre
log_write($data);

// Exec
$response = exec_curl($action());

// Post
if(!$entoken) {
  write_partner_token($response);
}

// --- end of post
log_write($response);

header('Content-Type: application/json');
echo $response->data;

exit();

/**
 * Pub
 */

/*
Token
 */

function refresh_token() {
  global $data;
  $data['method']='getToken';
  $url = get_url(
    "https://api-sandbox.tiket.com/apiv1/payexpress",
    $data
  );
  return $url;
}

/*
General
 */

function list_currency() {
  global $data;
  $url = get_url(
    "https://api-sandbox.tiket.com/general_api/listCurrency", 
    $data
  );
  return $url;
}

function list_language() {
  global $data;
  $url = get_url(
    "https://api-sandbox.tiket.com/general_api/listLanguage", 
    $data
  );
  return $url;
}

function get_policies() {
  global $data;
  $url = get_url(
    "https://api.tiket.com/general_api/getPolicies",
    $data
  );
  return $url;
}

/*
Partner
 */

function get_saldo() {
  global $data;
  $url = get_url(
    "https://api-sandbox.tiket.com/partner/transactionApi/get_saldo",
    $data
  );
  return $url;
}

function transaction() {
  global $data;
  $url = get_url(
    "https://api-sandbox.tiket.com/partner/transactionApi",
    $data
  );
  return $url;
}

function order() {
  global $data;
  $url = get_url(
    "https://api-sandbox.tiket.com/order",
    $data
  );
  return $url;
}

function check_order() {
  global $data;
  $data['order_id']=$_GET['order_id'];
  $data['email']='urfan.laode@gmail.com';
  $url = get_url(
    "https://api-sandbox.tiket.com/check_order",
    $data
  );
  return $url;
}

function confirm() {
  global $data;
  global $var;
  $data['order_id']=$_GET['order_id'];
  $data['textarea_note']='test';
  $data['tanggal']=$var['today'];
  $url = get_url(
    "https://api-sandbox.tiket.com/partner/transactionApi/confirmPayment",
    $data
  ); 
  return $url;
}

/*
Flight
 */

function search_flight() {
  global $data;
  global $var;
  $data['d']='CGK';
  $data['a']='DPS';
  $data['date']=$var['date'];
  // $data['ret_date']=$var['ret_date'];
  $data['adult']='1';
  $data['child']='0';
  $data['infant']='0';
  $data['v']='3';
  $url = get_url(
    "https://api-sandbox.tiket.com/search/flight",
    $data
  );
  return $url;
}

function check_flight_update() {
  global $data;
  global $var;
  $data['d']='CGK';
  $data['a']='DPS';
  $data['date']=$var['date'];
  $data['adult']='1';
  $data['child']='0';
  $data['infant']='0';
  $timestamp=date('mdHis');
  $data['time']=$timestamp;
  $url = get_url(
    "https://api-sandbox.tiket.com/ajax/mCheckFlightUpdated",
    $data
  );
  return $url;
}

function get_flight_data() {
  global $data;
  global $var;
  $data['flight_id']=$var['flight_id'];
  $data['date']=$var['date'];
  // $data['ret_flight_id']=$_GET['ret_flight_id'];
  // $data['ret_date']=$_GET['ret_date'];
  $url = get_url(
    "https://api-sandbox.tiket.com/flight_api/get_flight_data",
    $data
  );
  return $url;
}

function get_nearest_airport($via='ip') {
  global $data;
  switch ($via) {
    case 'ip':
      // $data['ip']=$_SERVER['REMOTE_ADDR']; // incoming public network
      $data['ip']=file_get_contents('http://ipecho.net/plain'); // incoming local network
      break;
    case 'coordinate':
      $data['latitude']='';
      $data['longitude']='';
      break;    
    default:
      break;
  }
  $url = get_url(
    "http://api-sandbox.tiket.com/flight_api/getNearestAirport",
    $data
  );
  return $url;
}

function get_popular_dest() {
  global $data;
  $data['depart']='CGK';
  $url = get_url(
    "https://api-sandbox.tiket.com/flight_api/getPopularDestination",
    $data
  );
  return $url;
}

function all_airport() {
  global $data;
  $url = get_url(
    "https://api-sandbox.tiket.com/flight_api/all_airport",
    $data
  );
  return $url;
}

function order_add_flight() {
  global $data;
  global $var;
  // 
  $data['flight_id']=$var['flight_id'];
  // $data['ret_flight_id']=$var['ret_flight_id'];
  $data['lioncaptcha']='';
  $data['lionsessionid']='';
  $data['infant']='0';
  $data['child']='0';
  $data['adult']='1';
  $data['conSalutation']='Mr';
  $data['conFirstName']='Urfan';
  $data['conLastName']='Laode';
  $data['conPhone']='+6281278810028';
  $data['conEmailAddress']='urfan.laode@gmail.com';
  $data['titlea1']='Mr';
  $data['firstnamea1']='Windy';
  $data['lastnamea1']='Cuana';
  $data['birthdatea1']='1991-05-19';
  $data['ida1']='';
  $data['conOtherPhone']='+6281278810028';
  $data['titlec1']='';
  $data['firstnamec1']='';
  $data['lastnamec1']='';
  $data['birthdatec1']='';
  $data['idc1']='';
  $data['titlei1']='';
  $data['parenti1']='';
  $data['firstnamei1']='';
  $data['lastnamei1']='';
  $data['birthdatei1']='';
  // additional 1
  $data['pasportnoa1']='';
  $data['passportExpiryDatea1']='';
  $data['passportissueddatea1']='';
  $data['birthdatea1']='';
  $data['passportissuinga1']='';
  $data['passportnationalitya1']='';
  // additional 2
  $data['dcheckinbaggagea11']='';
  $data['dcheckinbaggagec11']='';
  $data['rcheckinbaggagea11']='';
  $data['rcheckinbaggagec11']='';
  $url = get_url(
    "https://api-sandbox.tiket.com/order/add/flight",
    $data
  );
  return $url;
}

function order_delete() {
  global $data;
  $data['order_detail_id']=$_GET['order_detail_id'];
  $url = get_url(
    "https://api-sandbox.tiket.com/order/delete_order",
    $data
  );
  return $url;
}

function checkout() {
  global $data;
  $order_id=$_GET['order_id'];
  $url = get_url(
    "https://api-sandbox.tiket.com/order/checkout/$order_id/IDR",
    $data
  );
  return $url;
}

function checkout_customer() {
  global $data;
  $data['salutation']='Mr';
  $data['firstName']='Urfan';
  $data['lastName']='Laode';
  $data['emailAddress']='urfan.laode@gmail.com';
  $data['phone']='+6281278810028';
  $data['saveContinue']='2';
  $url = get_url(
    "https://api-sandbox.tiket.com/checkout/checkout_customer",
    $data
  );
  return $url;
}

function checkout_payment() {
  /**
   * Payment
   * 0 : hold checkout payment
   * 1 : checkout payment
   */

  /**
   * Payment Method
   * 8 : Deposit
   * 
   */
  global $data;
  $payment_method='8';
  $data['btn_booking']=$_GET['btn_booking'];
  $url = get_url(
    "https://api-sandbox.tiket.com/checkout/checkout_payment/$payment_method",
    $data
  );
  return $url;
}

/*
Lion
 */

function get_lion_captcha() {
    global $data;
    $url = get_url(
      "http://api-sandbox.tiket.com/flight_api/getLionCaptcha",
      $data
    );
    return $url;
}

/**
 * Pvt
 */

function load_env() {
  return parse_ini_file(".env", 1);
}

function load_partner_data() {
  global $partner;

  $partner = load_env()['partner'];
}

function load_partner_open_data() {
  global $partner;

  $partner['twh']='24437121';
}

function load_partner_token() {
  global $partner;

  $partner['token']=json_decode(file_get_contents('data/token.json'))->token;
}

function write_partner_token($response) {
  if ($response->rc == '00') {
    if(file_put_contents('data/token.json', $response->data)) {
      return $response->rc.":".'store success';
    } else {
      return $response->rc.":".'store failed';
    }
  } else {
    return $response->rc.":".$response->message;
  }
}

function get_url($url, $data) {
  $query = http_build_query($data);
  return "$url?$query";
}

function exec_curl($url) {
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "$url",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    return (object) array(
      'rc' => '05',
      'message' => "cURL Error #:" . $err
      );
  } else {
    return (object) array(
      'rc' => '00',
      'data' => $response
      );
  }
}

// Logs
function log_write($data) {
  file_put_contents('logs/app.log', "[".date("Y-m-d h:i:sa")."]".print_r($data, true).PHP_EOL, FILE_APPEND);
}
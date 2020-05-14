<? php include 'responseprocessing.php'? >

  <? php startblock('link') ? >

  <link href = "../careersurvey/css/landing-page.css" rel = "stylesheet" >

  <? php endblock() ? >


  <? php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  function callService($service) {
    $url = "https://services.onetcenter.org/ws/".$service;
    $ch = curl_init();
    $config = parse_ini_file('../../../config.ini');
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $config['onet']);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $xml = curl_exec($ch);
    if (curl_error($ch)) {
      echo 'error:'.curl_error($ch);
    }
    return $xml;
  }

  $jobrequest = $_SESSION['returnedjob'];
  $make_request = callService("online/occupations/".$jobrequest.
    "/summary/technology_skills");
  $xml = simplexml_load_string($make_request);
  $xml = new SimpleXMLElement($make_request);
  $titles = [];
  $examples = [];
  setlocale(LC_MONETARY, 'en_US');


  //create a loop through each object to get and store the title values I need
  foreach($xml as $atitle) {
    array_push($examples, $atitle - > example);
    array_push($titles, $atitle - > title);

  }
  // print_r($examples);
  // print_r($titles);
  $title1 = $titles[0][0];
  $title2 = $titles[1][0];
  $title3 = $titles[2][0];
  $title4 = $titles[3][0];
  $title5 = $titles[4][0];


  $thejobname = $_SESSION['returnedjobName'];
  $thetotalemployed = $_SESSION['returnedtotEmp'];
  $themedianwage = $_SESSION['returnedmedianwage'];
  $dollaramount = number_format($themedianwage);


  echo "<strong>".$title1."</strong>";
  $title1Example1 = $examples[0][0];
  echo "<br>".$title1Example1;
  $title1Example2 = $examples[0][1];
  echo "<br>".$title1Example2;
  $title1Example3 = $examples[0][2];
  echo "<br>".$title1Example3;
  $title1Example4 = $examples[0][4];
  echo "<br>".$title1Example4.



?>

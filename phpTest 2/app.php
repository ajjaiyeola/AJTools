<?php include 'responseprocessing.php'?>

<?php startblock('link') ?>

    <link href="../careersurvey/css/landing-page.css" rel="stylesheet">

<?php endblock() ?>


<?php




ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function callService($service) {
    $url = "https://services.onetcenter.org/ws/" . $service;
    $ch = curl_init();
    $config = parse_ini_file('../../../config.ini');
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $config['onet']);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $xml = curl_exec($ch);

    if(curl_error($ch))
        {
            echo 'error:' . curl_error($ch);
        }

    return $xml;
}



//perform request to ONET here
    $jobrequest = $_SESSION['returnedjob'];
    $make_request = callService("online/occupations/".$jobrequest."/summary/technology_skills");
    $xml=simplexml_load_string($make_request);
    $xml = new SimpleXMLElement($make_request);
    $titles = [];
    $examples = [];
    setlocale(LC_MONETARY, 'en_US');
    // print_r($xml);

    //create a loop through each object to get and store the title values I need
    foreach($xml as $atitle){
        array_push($examples, $atitle->example);
        array_push($titles, $atitle->title);

    }
    // print_r($examples);
    // print_r($titles);
    $title1 = $titles[0][0];
    $title2 = $titles[1][0] ;
    $title3 = $titles[2][0] ;
    $title4 = $titles[3][0];
    $title5 = $titles[4][0];


    $thejobname = $_SESSION['returnedjobName'];
    echo "<h2>".$thejobname."</h2>";

    $thetotalemployed = $_SESSION['returnedtotEmp'];
    // echo gettype($thetotalemployed);
    echo "<p> There are ".number_format($thetotalemployed)." people currently employed in this field.</p>";

    $themedianwage = $_SESSION['returnedmedianwage'];
    $dollaramount = number_format($themedianwage);
    // echo $dollaramount;
    echo "<p> There median wage is currently  ".money_format('%i',$dollaramount*1000).".</p>";


    echo "<strong>".$title1."</strong>";
    $title1Example1 = $examples[0][0];
    echo "<br>".$title1Example1;
    $title1Example2 = $examples[0][1];
    echo "<br>".$title1Example2;
    $title1Example3 = $examples[0][2];
    echo "<br>".$title1Example3;
    $title1Example4 = $examples[0][4];
    echo "<br>".$title1Example4."<br>";

    echo "<strong>".$title2."</strong>";
    $title2Example1 = $examples[1][0];
    echo "<br>".$title2Example1;
    $title2Example2 = $examples[1][1];
    echo "<br>".$title2Example2;
    $title2Example3 = $examples[1][2];
    echo "<br>".$title2Example3;
    $title2Example4 = $examples[1][4];
    echo "<br>".$title2Example4."<br>";;

    echo "<strong>".$title3."</strong>";
    $title3Example1 = $examples[2][0];
    echo "<br>".$title3Example1;
    $title3Example2 = $examples[2][1];
    echo "<br>".$title3Example2;
    $title3Example3 = $examples[2][2];
    echo "<br>".$title3Example3;
    $title3Example4 = $examples[2][4];
    echo "<br>".$title3Example4."<br>";;

    echo "<strong>".$title4."</strong>";
    $title4Example1 = $examples[3][0];
    echo "<br>".$title4Example1;
    $title4Example2 = $examples[3][1];
    echo "<br>".$title4Example2;
    $title4Example3 = $examples[3][2];
    echo "<br>".$title4Example3;
    $title4Example4 = $examples[3][4];
    echo "<br>".$title4Example4."<br>";;

    echo "<strong>".$title5."</strong>";
    $title5Example1 = $examples[4][0];
    echo "<br>".$title5Example1;
    $title5Example2 = $examples[4][1];
    echo "<br>".$title5Example2;
    $title5Example3 = $examples[4][2];
    echo "<br>".$title5Example3;
    $title5Example4 = $examples[4][4];
    echo "<br>".$title5Example4."<br>";;



    //create a loop through each title to store the examples I need



?>


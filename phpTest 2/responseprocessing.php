<?php include 'base.php'?>

<?php
session_start();

//user completes questionnaire and data is sent to server
	//take user responses and set each to a variable

$degree = $job = $industry = $thenewjob = $answer = $thejob ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $degree = test_input($_POST["degree"]);
  $job = test_input($_POST["jobChoice"]);
  $industry = test_input($_POST["industry"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


function db_connect() {
	try{
			$config = parse_ini_file('../../../config.ini'); 
			$servername ="localhost";
			$username = $config['username'];
			$password = $config['password'];
			$dbname = $config['dbname'];
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
			

			//database connection must run before any prepared statement is executed
	}
	catch(PDOException $e)
    {
    	echo "Error: " . $e->getMessage();
    }
    
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$start = db_connect();
	if($job !=""){
	$statement = $start->prepare("SELECT * FROM `TABLE 4` where jobName = :job");
	$statement->execute(array(':job' => $job));
	$thejob = $statement->fetch();
	
	// print_r($thejob);

	if($statement->rowCount() == 1){
		$_SESSION['returnedjob'] = $thejob['jobCode'];
		$_SESSION['returnedtotEmp'] = $thejob['totEmp'];
		$_SESSION['returnedmedianwage'] = $thejob['meanannual'];
		$_SESSION['returnedjobName'] = $thejob['jobName'];
		// echo "1. the job is ".$thejob[0];
		//check if degree exists in same row as job
		if($degree !=""){
			$newstart = $start->prepare("SELECT degree1 FROM `TABLE 4` where ((degree1 = :degree) OR (degree2= :degree) 
				OR (degree3= :degree) OR (degree4= :degree) or (degree5 = :degree)) AND jobName = :job");
			$newstart->bindValue(':degree', $degree);
			$newstart->bindValue(':job', $job);
			$newstart->execute();
			$thedegree = $newstart->fetch(); 
			if($newstart->rowCount() == 1){
				$_SESSION['returneddegree'] = $thedegree['degree1'];

				// echo "<br>"."2. the degree is ".$thedegree[0];
				//i use the session above to determine if degree is present for the entered job and then
				//running the necessary code if degree is present
			}
			//check if degree exists in other rows 
				$thirdstart = $start->prepare("SELECT * FROM `TABLE 4` where ((degree1 = :degree) OR (degree2= :degree) 
				OR (degree3= :degree) OR (degree4= :degree) or (degree5 = :degree)) AND jobName != :job");
				$thirdstart->bindValue(':degree', $degree);
				$thirdstart->bindValue(':job', $job);
				$thirdstart->execute();
				if($thirdstart->rowCount() >= 1){
					$theotherdegrees = $thirdstart->fetchAll(); 
					$_SESSION['theotherdegrees'] = $theotherdegrees;
					// echo "<br>"."3. the degree is ".$theotherdegree[0][0];
					//the session above should give me the data for all the rows where the degree entered is present, 
					//in a situation where the job entered was not present. If I want the data for the other degrees, even whe the job 
					//data is not present, I can still use the returned data here.
				}
		}
		//if there is a match, return degree

		//check if the industry exists in same row as job
				if($industry !=""){
					$fourthstart = $start->prepare("SELECT industry1 FROM `TABLE 4` where ((industry1 = :industry) OR (industry2= :industry) OR 
					(industry3= :industry) OR (industry4= :industry) or (industry5 = :industry)) AND jobName = :job");
					$fourthstart->bindValue(':industry', $industry);
					$fourthstart->bindValue(':job', $job);
					$fourthstart->execute();
					$theindustry = $fourthstart->fetch(); 
					if($fourthstart->rowCount() == 1){
						$_SESSION['theindustry'] = $theindustry['industry1'];
						// echo"<br>"."4. the industry is ".$theindustry[0]."<br>";
					}
						$fifthstart = $start->prepare("SELECT * FROM `TABLE 4` where ((industry1 = :industry) OR (industry2= :industry) OR 
						(industry3= :industry) OR (industry4= :industry) or (industry5 = :industry)) AND jobName != :job");
						$fifthstart->bindValue(':industry', $industry);
						$fifthstart->bindValue(':job', $job);
						$fifthstart->execute();
						if($fifthstart->rowCount() >= 1){
							$theotherindustry = $fifthstart->fetchAll(); 
							$_SESSION['theotherindustries'] = $theotherindustries;

							// echo "<br>"."5. the industry is ".$theotherindustry[0][0];
						}
				}
		//check in degree exists in rows where job does not	
				header('Location: app.php');
	}
	elseif($statement->rowCount() == 0){
		//check if a similar text exists in db
		$sub = mb_substr($job, 0, 5);
		$realsub = "%".$sub."%";
		$newstatement = $start->prepare("SELECT jobName FROM `TABLE 4` where jobName LIKE :job");
		$newstatement->execute(array(':job' => $realsub));
		if($newstatement->rowCount() >= 1){
			$thenewjob = $newstatement->fetchAll();

			 //use this arra on the front end to form the error options
			// echo "<br>"."6. the similar job is ".$thenewjob[0][0]." and ".$thenewjob[1][0]."<br>";
		}
		else

	
		{
			//if there is no similar match in db, use combo of levenshtein and json file
			$go = file_get_contents('samplejobs.json');
			$options_array = json_decode($go, true);
			$input = $job;
			$words  = $options_array;
		// no shortest distance found, yet
			$shortest = -1;
			foreach ($words as $word) {
			    // calculate the distance between the input word,
			    // and the current word
			    $lev = levenshtein($input, $word);
			    if ($lev == 0) {
			        $closest = $word;
			        $shortest = 0;
			        // break out of the loop; we've found an exact match
			        break;
			    }
			    if ($lev <= $shortest || $shortest < 0) {
			        // set the closest match, and shortest distance
			        $closest  = $word;
			        $shortest = $lev;
			    }
			}
			// echo "Input word: $input\n";
			if ($shortest == 0) {
		   		// echo "Exact match found: $closest\n";
		   		$answer = $closest;
		  	} else {
		    	// echo "<br>Did you mean: $closest?\n";
		    	$answer = $closest;

				}
		}
	}
}
		//check if degree exists in row for any other jobs. return all pertinent rows if so
	// if($job=""){
		if($degree !=""){
			$newstart = $start->prepare("SELECT jobCode FROM `TABLE 4` where ((degree1 = :degree) OR (degree2= :degree) 
			OR (degree3= :degree) OR (degree4= :degree) or (degree5 = :degree)) ");
			$newstart->bindValue(':degree', $degree);
			$newstart->execute();
			if($newstart->rowCount() >= 1){
				$thedegree = $newstart->fetchAll();
				echo "<br>"."8. the degree is ".$thedegree[0][0];
			}
	}	
		//check if industry exists in row for any other jobs. return if so
			if($industry != ""){
				$thirdstart = $start->prepare("SELECT jobCode FROM `TABLE 4` where ((industry1 = :industry) OR (industry2= :industry) 
				OR (industry3= :industry) OR (industry4= :industry) or (industry5 = :industry)) ");
				$thirdstart->bindValue(':industry', $industry);
				$thirdstart->execute();
				if($thirdstart->rowCount() >= 1){
					$theindustry = $thirdstart->fetchAll();
					echo"<br>"."9. the industry is ".$theindustry[0][0]."<br>";
				}
			}
	} 
// }




//determine if where user's response falls in the matrix of possibilities

// Send request to ONET and get xml response, if there is any match in matrix

//if there is no matrix match, send error report

//Pass xml response for processing and assigning results to appropriate variables











?>
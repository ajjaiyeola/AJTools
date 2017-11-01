<?php include 'responseprocessing.php'?>


<?php startblock('link') ?>

	<link href="../careersurvey/css/landing-page.css" rel="stylesheet">

<?php endblock() ?>



<?php startblock('main') ?>

    <div class="intro-header"> 
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                        <div class="intro-message">

<?php
// echo "<h2>Your Input:</h2>";
// echo "job:".$job;
// echo "<br>";
// echo "industry:".$industry;
// echo "<br>";
// echo "degree:".$degree;
// echo "<br>";

?>
                            <H2> Skill Assessment Questionnaire</H2>
                            <p>Answer the questions below to receive your tailored skill-building plan based on the field you are interested in</p><br>
                            <form id="truForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                                  <div class="form-group">
                                    <label for="formGroupExampleInput"> What are you currently studying in College? If you are a graduate, what did you study?</label>
                                    <input type="text" class="form-control" id="ajax" list="json-datalist" placeholder="Example input" name="degree">
                                    <datalist id="json-datalist"></datalist>
                                  </div>
                                    <fieldset class="form-group">
                                        <label>Do you have a job role in mind that you are interested in?</label><br>
                                          <div class="col-sm-10">
                                            <div class="form-check">
                                              <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" name="jobQuestion">
                                                Yes
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <label class="form-check-label">
                                                <input class="form-check-input check1" type="radio" name="gridRadios" id="gridRadios2" value="option2" >
                                                No, I am looking to LevelCareers to suggest some to me
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="option3">
                                                I do, but I'm flexible 
                                              </label>
                                            </div>
                                          </div>
                                    </fieldset>
                                  <div class="form-group" id="roleQuestion">
                                    <label for="formGroupExampleInput2" >What role are you interested in?</label>
                                    <input type="text" class="form-control thejobvalue" id="ajax2" list="second" placeholder="Another input" name="jobChoice">
                                    <datalist id="second"></datalist>

                                    <?php
                                    // take the array of returned suggestions and present to user
                                    if($thenewjob){
                                      echo "<div class='alert-danger options'>";
                                      $indi ="";
                                      $thesize = sizeof($thenewjob) - 1;
                                      foreach($thenewjob as $option){
                                        if($option != $thenewjob[$thesize]){
                                          $indi .='<a class="anOption">'.$option[0].", ".'</a>';
                                        }
                                        else {
                                          $indi .="or ".'<a class="anOption">'.$option[0].'</a>'."?";
                                             }
                                
                                      }

                                      echo "Did you mean: ".$indi."</div>" ;
                                    }
                                    if($answer !=""){
                                    echo "<div class='alert-danger options'>"."Did you mean: ".'<a class="anOption">'.$answer.'</a>'."?"."</div>";
                                    }

                                    ?>


                                  </div>
                                <fieldset class="form-group">
                                        <label>Are you particularly interested in any industry?</label><br>
                                          <div class="col-sm-10">
                                            <div class="form-check">
                                              <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="gridRadios1" id="gridRadios4" value="option1" name="industryQuestion">
                                                Yes
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="gridRadios1" id="gridRadios5" value="option2">
                                                No, I am looking to LevelCareers to suggest some to me
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="gridRadios1" id="gridRadios6" value="option3">
                                                I am, but I'm flexible 
                                              </label>
                                            </div>
                                          </div>
                                </fieldset>
                                <div class="form-group" id="industryQuestion">
                                    <label for="formGroupExampleInput">What industry are you interested in?</label>
                                    <input type="text" class="form-control" id="ajax3" list="third" placeholder="Example input" name="industry">
                                    <datalist id="third"></datalist>
                                </div>
                                
                                <div style="text-align: center;">
                                    <input type="submit" name="submit" value="Submit">
                                </div>
                            </form>                           
                        </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
<?php endblock() ?>
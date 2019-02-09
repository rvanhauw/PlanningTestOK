<?php
/*
Rik Van Hauwe
6/2/2019

Test Opdracht:

Make a php-console script that creates a csv file. The csv file is a template containing a list of meeting dates that can be used for planning. The script requests for input:
•	A start date from which the planning should be created
•	An interval in days that should be respected
•	An end date

The csv should contain the number of the meeting and the date.

The script should generate the file with all meeting dates from the start date till the end date. Keep in mind:
•	The meeting dates should be on each n-th day, based on the given interval
•	A meeting can’t be in the weekend
•	Saturday and Sunday should not be counted as days
•	A meeting can’t be on the 25/12 or 1/1
•	A meeting can’t be on the 5th of 15th of each month

You decide if you use a framework, other technologies or plain php. The code should work for at least php 7.0. Please send the code using GIT (Github or Bitbucket)


My Remarks:

- simple file structure (no classes used - could be made with Laravel / Symphony / Wordpress ...) : just PHP with "index.php" and "functions.php"

- using CDN avoiding local files

- visual selection of dates using bootstrap-datepicker (can be done without using eg dropdowns)

- no error checking on the csv part

- simple csv output to fixed file with header record

 */



include "functions.php";

$errors = ['ok', 'weekend error', 'new year error', 'christmas error', '5 or 15 error'];

$success = false;

$e_number = "enter number";
$e_bdate = "enter date";
$e_edate = "enter date";

if (isset($_POST['submit'])) {
//  print_r($_POST);
  $bmine = "";
  if ($_POST['bdate']) {
    $bmine = $_POST['bdate'];
    $e_bdate = "";
    $valid = valid_date($bmine);
    if ($valid == 0) {
      $e_number = "";
      if ($_POST['number']) {
        $number = $_POST['number'];
        if ($number >= 1) {
          $emine = "";
          if ($_POST['edate']) {
            $emine = $_POST['edate'];
            $e_edate = "";
            $valid = valid_date($emine);
            if ($valid == 0) {
              $e_number = "";
              if ($_POST['number']) {
                $number = $_POST['number'];
                if ($number >= 1) {
                  $dd = get_next_meeting_day($bmine, $number);
                  if (date('Y-m-d', strtotime($emine)) >= date('Y-m-d', strtotime($dd))) {
                    $meetings = create_meeting_days($bmine, $number, $emine);
                    outputCsv('meetings.csv', $meetings);
                    $success = true;
                  } else {
                    $e_number = "end date or interval error";
                    $e_edate = "end date or interval error";
                  }
                } else {
                  $e_number = "number error";
                }
              } else {
                $e_number = "Type a valid number";
              }
            } else {
              $e_edate = $errors[$valid];
              $e_number = "";
            }
          } else {
            $e_number = "";
          }
        } else {
          $e_number = "number error";
        }
      } else {
        $e_number = "input number";
      }
    } else {
      $e_bdate = $errors[$valid];
      $e_number = "";
      $e_edate = "";
    }
  } else {
    $e_number = "";
  }
}

?>

<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
    <title>Meeting Planner</title>  
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>  
  </head>

  <body>
  <div class="container">
    <br/> 
    <h2>Planning scheduler</h2>
    <strong>Begin Date : </strong>Click and choose a valid date!
    <form action="index.php" method="post">
    
      <input class="date form-control" style="width: 120px;" type="text" name="bdate" 
      <?php
      if (isset($_POST['bdate'])) {
        print ' value="' . $_POST['bdate'] . '"';
      }
      ?>
      >
      <span class="primary" style="color:red">
        <?php 
        if (isset($_POST['bdate']) && $e_bdate) echo $e_bdate;
        ?>
      </span>
       <br/><br/> 

      <strong>Interval: </strong> number of valid days between meetings
      <br/>
      <input type="number" min="1" style="width: 80px;" name='number' 
        <?php
        if (isset($_POST['number'])) {
          print ' value="' . $_POST['number'] . '"';
        } else {
          print ' value="' . "1" . '"';
        }
        ?>
      />
      <span class="primary" style="color:red">
        <?php 
        if (isset($_POST['number']) && $e_number) echo $e_number;
        ?>
      </span>

      <br/>   <br/> 
      <br/>   <br/> 

      <strong>End Date : </strong>Click and choose a valid date!
      <input class="date form-control" style="width: 120px;" type="text" name="edate" 
        <?php
        if (isset($_POST['edate'])) {
          print ' value="' . $_POST['edate'] . '"';
        }
        ?>
      >
      <span class="primary" style="color:red">
        <?php 
        if (isset($_POST['edate']) && $e_edate) echo $e_edate;
        ?>
      </span>

      <br/>   <br/> 
      <br>
      <br>
      <input type="submit" name="submit" value="Make Planning"/>
    </form>

    <?php if ($success) {
      echo "<h4>Planning: " . sizeof($meetings) . " meetings created on csv file (meeting.csv)</h4>";
      echo "<br>";
      echo "<br>";
      foreach ($meetings as $meeting) {
        echo $meeting['id'] . " -> " . $meeting['day'];
        echo "<br>";

      }
    } ?>




  </div>
</body>


<script type="text/javascript">  
  $('.date').datepicker({  
    format: 'dd-mm-yyyy'  ,
    autoclose:true
  });  
</script>  
</html>
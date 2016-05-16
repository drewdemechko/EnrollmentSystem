<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<TITLE>Student Web Page</TITLE> 
</head>

<body>

<nav class="navbar navbar-inverse" style="background-color:rgb(40,95,143); margin-bottom:0">
    <div class="container-fluid">
        <div class="navbar-header">
			<div class="navbar-brand">
                <img src="http://busn.uco.edu/bahouth/UCO.jpg" style="position: absolute; width: 50px; height: 50px; left: 0; top: 0; border-radius: 5px;"/>
            </div>
            <div class="navbar-brand" style="color:white;margin-left: 30px">
                Student Enrollment <i class="glyphicon glyphicon-copyright-mark"></i>
            </div>
        </div>
    </div>
</nav>

<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$userid=$_GET["userid"];
$userno=$_GET["userno"];

$wheretocall = "admin";
$callingtype=$_GET["callingtype"];

if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

$gstudent_id=$_GET["student_id"];

// Here we can generate the content of the welcome page

if($callingtype == 1)
{
   echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
		<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
      <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
          <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"change_password.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Change Password</a></li>
      	  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_info.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Student Information</a></li>
	  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_record.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Student Record</a></li>
	  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"course_info.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">About Courses</a></li>	  
	  </ul>
		</div>");   
}
else
{
   echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
		<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
      <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
          <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"change_password.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Change Password</a></li>
	  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"admin.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Administrator</a></li>
      	  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_info.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Student Information</a></li>
	  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_record.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Student Record</a></li>
	  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"course_info.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">About Courses</a></li>	
         </ul>
		</div>");
}

// query semester
$sql = "select semester from Course";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}
else
{
   $idx = 0;
   while ($values = oci_fetch_array ($cursor)){
	$tsemester[$idx] = $values[0];
	$idx = $idx + 1;
   }
}

oci_free_statement($cursor);

//============= display drop-down box of semester ===========================================================//

$currentYear = date("Y");
$currentMonth = date("m");

echo("<form style='margin-left:20px; margin-top:20px' method=\"post\" action=\"student_enrollment.php?sessionid=$sessionid&callingtype=$callingtype&semester=$q_semester&student_id=$gstudent_id&userno=$userno\">
       <p>
           Semester : <select name = \"semester\"><option selected>Choose Semester</option>");

	   $tmp = "";
	   for($i = 0; $i < $idx; ++$i)
           {		     
                     if(strcmp($tmp,$tsemester[$i]) != 0)
	             {
			$sYear = strtok($tsemester[$i], ' ');                        
                        $sSemester = strtoupper(strtok(' '));
			$tmp = $tsemester[$i];

			if(($currentMonth >= 9) && ($sYear == $currentYear + 1) && (strcmp($sSemester,"SPRING") == 0))
			{                               
				echo("<option>$tsemester[$i]</option>");
			}
			elseif(($currentMonth >= 5) && ($currentMonth <= 8) && ($sYear == $currentYear) && (strcmp($sSemester,"FALL") == 0))
			{
				echo("<option>$tsemester[$i]</option>");
			}
			else
			{
				echo("<option>$tsemester[$i] (View Only)</option>");
			}			                        
		     }                        
           }
echo("</select>");
echo("<input style='margin-left:10px' class='btn btn-primary' type=\"submit\" value=\"Course Search\">
      </p>");
echo("</form>");

// ================================ display course info =========================================================================

$q_semester =  $_POST["semester"];
$viewOnly = false;

if(isset($q_semester))
{
	if(stripos($q_semester,'('))
	{
	        $viewOnly = true;
	        $tmpSemester = $q_semester;
	        $q_semester = strtok($tmpSemester, ' ');    
	        $q_semester = $q_semester . ' '.  strtok(' ');                    
	}

	$sql = "select seq_id, cno ,title,credit, classtime, max_seat, remained_seat, deadline " .
                            "from Course JOIN Course_description ON cno = course_no " .
                            "where semester like '$q_semester'";


	$result_array = execute_sql_in_oracle ($sql);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];

	if ($result == false){
	  display_oracle_error_message($cursor);
	  die("Client Query Failed.");
	}

echo("<div style='margin-left:20px'>");
echo"<h3>Look up classes to Add </h3>";
echo"<p><h4>Semester : $q_semester</h4>";	

echo"<form method=\"post\" action=\"student_enrollment_action.php?sessionid=$sessionid&callingtype=$callingtype&semester=$q_semester&student_id=$gstudent_id&userno=$userno\">";

if($viewOnly === false)
	echo"<input type=\"submit\" value=\"Register\">";
echo"<table>";
echo"<tr BGCOLOR=\"#E0EBEB\"><th></th> <th>Sequence ID</th> <th>Course NO</th> <th>Title</th> <th>Credit</th> <th>Class Time</th>".
    "<th>Max_Seat</th><th>Remained_Seat</th><th>Deadline</th></tr>";

// Fetch the result from the cursor one by one
	while ($values = oci_fetch_array ($cursor)){
		  $seqid = $values[0];
		  $course_no = $values[1];
		  $titile = $values[2];
		  $credit = $values[3];
		  $classtime = $values[4];
		  $max_seat = $values[5];
		  $remained_seat = $values[6];  
		  $deadline = $values[7];  

	  	  echo("<tr><td><input type=\"checkbox\" name=\"selectCourse[]\" value=\"$seqid\"></td><td>$seqid</td> <td>$course_no</td> <td>$titile</td> <td>$credit</td> <td>$classtime</td><td>$max_seat</td>.
                            <td>$remained_seat</td> <td>$deadline</td></tr>");
	}

	echo ("</table>");

	oci_free_statement($cursor);
}
echo("<input type='submit' value='Register' />");
echo("</form></div>");
?>
</body>
</html>

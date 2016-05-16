<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<TITLE>Administrator Web Page</TITLE> 
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

$loginid=$_GET["userid"];

$wheretocall = "admin";
$callingtype=$_GET["callingtype"];

if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

if($callingtype == 1)
{
   echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
		<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"change_password.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Change Password</a></li>
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_grade_enter.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Enter Student Grade</a></li>
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"admin.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Add a New User</a></li>
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"admin_add_student.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">View Students</a></li>
        </ul>
		</div>");
}
else
{
   echo("<ul>
       <li><a class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
       <li><a class = \"a1\" href=\"change_password.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Change Password</a></li>
       <li><a class = \"a1\" href=\"student.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Student</a></li>
       </ul>");
}

// Form the query and execute it
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

echo("<form style='margin-left:20px; margin-top:20px' method=\"post\" action=\"admin_search_student_by_courseno.php?sessionid=$sessionid&callingtype=$callingtype&semester=$q_semester\">
       <p>
       Course Number : <input type=\"text\" size=\"10\" maxlength=\"10\" name=\"q_course_no\">
           Semester : <select name = \"semester\"><option selected>Choose Semester</option>");

           $tmp = "";

	    for($i = 0; $i < $idx; ++$i)
           {
                     if(strcmp($tmp,$tsemester[$i]) != 0)
	             {
			if($i < 0)	
  	 		 	echo("<option selected>$tsemester[$i]</option>");
			else	                           
			 	echo("<option>$tsemester[$i]</option>");

                        $tmp = $tsemester[$i];
		        }
           }

echo("</select></p>");
echo("
      <p> 
          <input class='btn btn-primary' type=\"submit\" value=\"Search\">
      </p>
  </form>");


// Interpret the query requirements
$q_student_id = $_POST["q_student_id"];
$q_student_lname = $_POST["q_student_lname"];
$q_student_fname = $_POST["q_student_fname"];
$q_student_type = $_POST["q_student_type"];
$q_student_status = $_POST["q_student_status"];
$q_course_no = $_POST["q_course_no"];
$q_searchtype  = $_POST["searchtype"];
$q_semester =  $_POST["semester"];

echo("semester : $q_semester");

if(isset($q_semester))   // by course number
{
	 // Form the query and execute it
	$sql = "create view Selected_Course as select seq_id, cno, title, credit, student_id, grade " .
                            "from Course JOIN Course_description ON cno = course_no JOIN Course_taken ON seq_id = sequence_id " .
                            "where cno like '%$q_course_no%' and semester like '$q_semester'";

	$result_array = execute_sql_in_oracle ($sql);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];

	if ($result == false){
	  display_oracle_error_message($cursor);
	  oci_free_statement($cursor);
	  die("Client Query Failed.");
	}

	oci_free_statement($cursor);

	$sql = "select seq_id, cno, student_id, fname, lname, title, grade from Selected_Course JOIN Student ON student_id = sid order by seq_id ";

	$result_array = execute_sql_in_oracle ($sql);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];

	if ($result == false){
	  display_oracle_error_message($cursor);
	  die("Client Query Failed.");
	}

	echo "<table border=1>";
	echo "<tr> <th>Sequence ID</th>  <th>Course No</th> <th>Student ID</th> <th>Last Name</th> <th>First Name</th> <th>Grade</th> </tr>";
	
	// Fetch the result from the cursor one by one

	while ($values = oci_fetch_array ($cursor)){
		  $seqid = $values[0];
		   $course_no = $values[1];
		  $sid = $values[2];
		  $fname = $values[3];
		  $lname = $values[4];
		  $title = $values[5];
		  $grade = $values[6];  
	
	  	  echo("<tr><td>$seqid</td> <td>$course_no</td> <td>$sid</td> <td>$lname</td> <td>$fname</td><td>$grade</td></tr>");
	}
	echo ("</table>");

	oci_free_statement($cursor);

	$sql = "drop view Selected_Course";

	$result_array = execute_sql_in_oracle ($sql);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];

	if ($result == false){
	  display_oracle_error_message($cursor);
	  die("Client Query Failed.");
	}
	oci_free_statement($cursor);	
}
?>


</body>

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
$userno=$userid;

$wheretocall = "student";

$callingtype=$_GET["callingtype"];

if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

if($student_id == NULL)
{
	// read student id to $student_id
	$sql = "select sid from student where user_id = '$userid'";        
	
	$result_array = execute_sql_in_oracle ($sql);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];

	if ($result == false){
	  display_oracle_error_message($cursor);
	  die("Client Query Failed.");
	}

	$values = oci_fetch_array ($cursor);
	$gstudent_id = $values[0];
	oci_free_statement($cursor);
}



// Here we can generate the content of the welcome page
if($callingtype == 1)
{  
   echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
		<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
      <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
      <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"change_password.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Change Password</a></li>
      <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_info.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Student Information</a></li>
	  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_record.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Student Record</a></li>
	  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"course_info.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">About Courses</a></li>
	  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_enrollment.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&student_id=$gstudent_id&userno=$userno\">Enroll Classes</a></li>
	  </ul>
		</div>");
}
else
{
   echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
		<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
      <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
      <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"change_password.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Change Password</a></li>
      <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"admin.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Administrator</a></li>
	  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_info.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Student Information</a></li>
	  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_record.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Student Record</a></li>
	  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"course_info.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">About Courses</a></li>
	  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_enrollment.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&student_id=$gstudent_id&userno=$userno\">Enroll Classes</a></li>     
      </ul>
		</div>");
}
  
echo("<img src=\"student.jpg\" alt=\"Be Creative!\" style=\"width:150px;height:150px; position:absolute; right:50px; bottom: 50px;\"> ");

echo("<div style='margin-top:20px' class='container'> 
	<h3 style='text-align:center'> 
	Welcome to the University of Central Oklahoma Student Enrollment System!
	<br> <br> We hope you do well here!</h3></div>");

?>
</body>

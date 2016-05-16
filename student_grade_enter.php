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

// Here we can generate the content of the welcome page

if($callingtype == 1)
{
   echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
		<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"change_password.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Change Password</a></li>
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"admin_add_student.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">View Students</a></li>
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"admin.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Add a New User/ List students</a></li>
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

   echo("<br><br>
  <form style='margin-left:20px; margin-top: 20px' method=\"post\" action=\"student_grade_enter_action.php?sessionid=$sessionid&userid=$loginid&callingtype=$callingtype\">
  <p> Student ID : <input type=\"text\" size=\"8\" maxlength=\"8\" name=\"q_student_id\" autofocus required>
      Course Sequence ID : <input type=\"text\" size=\"15\" maxlength=\"15\" name=\"q_course_sid\" required>
      Grade : <input type=\"text\" size=\"2\" maxlength=\"2\" name=\"q_grade\" required></p>
   <p><input  class='btn btn-primary' type=\"submit\" value=\"Submit\"></p> 
  </form>   
  ");

?>
</body>

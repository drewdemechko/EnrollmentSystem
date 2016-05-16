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
$loginid =$_SESSION['loginid'];
$wheretocall =$_GET["wheretocall"];

$callingtype=$_GET["callingtype"];

if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

if($wheretocall == "admin")
{
echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
	<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
  <li style='margin:20px;'><a style='color:white' class = 'a1' href='logout_action.php?sessionid=$sessionid'>Logout</a></li>
  <li style='margin:20px;'><a style='color:white' class = 'a1' href='admin.php?sessionid=$sessionid&userid=$loginid&callingtype=$callingtype'>Go Back</a></li>
  <li style='margin:20px;'><a style='color:white' class = 'a1' href='student_grade_enter.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype'>Enter Student Grade</a></li>
  <li style='margin:20px;'><a style='color:white' class = 'a1' href='admin.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype'>Add a New User</a></li>
  <li style='margin:20px;'><a style='color:white' class = 'a1' href='admin_search_student_by_courseno.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype'>List students by Course No</a></li>
  </ul>
	</div>");
}
else if(trim($wheretocall) == "student")
{

echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
	<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student.php?sessionid=$sessionid&userid=$loginid&callingtype=$callingtype\">Go Back</a></li>
   <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_info.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Student Information</a></li>
   <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_record.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Student Record</a></li>
  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"course_info.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">About Courses</a></li>
   <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_enrollment.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Enroll Classes</a></li>
  </ul>
	</div>");
}

// display the record to be updated.  
echo("
  <form style='margin-left:20px; margin-top:20px' method=\"post\" action=\"change_password_action.php?sessionid=$sessionid&wheretocall=$wheretocall&callingtype=$callingtype\">
  Userid (Read-only) : <input type=\"text\" readonly = \"readonly\" value = \"$loginid\" size=\"30\" maxlength=\"8\" name=\"userid\"> <br><br>
  Current Password    :  <input type=\"text\" size=\"30\" maxlength=\"12\" name=\"currentpassword\" autofocus required> <br><br>  
  New Password          : <input type=\"text\" size=\"30\" maxlength=\"12\" name=\"newpassword\" required> <br><br>
  Confirm Password    : <input type=\"text\" size=\"30\" maxlength=\"12\" name=\"confirmpassword\" required> <br><br>  
  <input class='btn btn-primary' type=\"submit\" value=\"Update\">
  </form> 
  ");
?>
</body>

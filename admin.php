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
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"admin_add_student.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Add a new student</a></li>
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"admin_search_student_by_courseno.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">List students by Course No</a></li>
        </ul>
		</div>");
}
else
{
   echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
		<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
       <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
       <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"change_password.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Change Password</a></li>
       <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Student</a></li>
       </ul>
		</div>");
}

echo("<br><br>
  <form method=\"post\" action=\"admin.php?sessionid=$sessionid&userid=$loginid&callingtype=$callingtype\" style='margin-left:20px'>
  UserID: <input type=\"text\" size=\"8\" maxlength=\"8\" name=\"q_userid\"> 
  UserType (0:Student, 1:Admin, 2: Student-Admin): <input type=\"text\" size=\"2\" maxlength=\"1\" name=\"q_usertype\">
  <input type=\"submit\" value=\"Search\">
  </form>
");

// Interpret the query requirements
$q_userid = $_POST["q_userid"];
$q_usertype = $_POST["q_usertype"];


$whereClause = " 1=1 ";

if (isset($q_userid) and trim($q_userid)!= "") { 
  $whereClause .= " and userid like '%$q_userid%'"; 
}

if (isset($q_usertype) and $q_usertype!= "") { 
  $whereClause .= " and usertype like '%$q_usertype%'"; 
}

// Form the query and execute it
$sql = "select userid, password, usertype from myuser where $whereClause order by userid";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

echo "<table class='table table-bordered table-striped' style='margin-left:20px; width:600px'>";
echo "<thead> <th>User ID</th> <th>Password</th> <th>User Type</th> <th>Update</th> <th>Delete</th> <th>Reset Password</th> </thead>";
// Fetch the result from the cursor one by one

while ($values = oci_fetch_array ($cursor)){
  $userid = $values[0];
  $password = $values[1];
  $usertype = $values[2];
  echo("<tbody> <tr>" . 
    "<td>$userid</td><td>$password</td> <td>$usertype</td> ".
    " <td> <A HREF=\"user_update.php?sessionid=$sessionid&userid=$userid&callingtype=$callingtype&loginid=$loginid\">Update</A> </td> ".
    " <td> <A HREF=\"user_delete.php?sessionid=$sessionid&userid=$userid&callingtype=$callingtype&loginid=$loginid\">Delete</A> </td> ".
      " <td> <A HREF=\"reset_password.php?sessionid=$sessionid&userid=$userid&callingtype=$callingtype&loginid=$loginid\">Reset</A> </td> ".
    "</tr></tbody>");
}

oci_free_statement($cursor);

echo "</table>";

?>
</body>

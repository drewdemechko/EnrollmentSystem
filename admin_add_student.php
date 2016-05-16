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

//echo("<br><BR> callingtype : $callingtype");

// Here we can generate the content of the welcome page

if($callingtype == 1)
{
//echo("<br><BR> callingtype : $callingtype");
   echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
		<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"change_password.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Change Password</a></li>
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_grade_enter.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Enter Student Grade</a></li>
        <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"admin.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Add a New User</a></li>
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
  <form style='margin-left:20px' method=\"post\" action=\"admin_add_student.php?sessionid=$sessionid&userid=$loginid&callingtype=$callingtype\">
  <p> Student ID : <input type=\"text\" size=\"8\" maxlength=\"8\" name=\"q_student_id\">
  Student Last Name : <input type=\"text\" size=\"15\" maxlength=\"15\" name=\"q_student_lname\">
   Student First Name : <input type=\"text\" size=\"20\" maxlength=\"20\" name=\"q_student_fname\"></p>
   <p> Student Type (0 : Undergraduate, 1: Graduate) : <input type=\"text\" size=\"1\" maxlength=\"1\" name=\"q_student_type\">
   Student Status (1: Probational) : <input type=\"text\" size=\"1\" maxlength=\"1\" name=\"q_student_status\">
</p>

  <input class='btn btn-primary' type=\"submit\" value=\"Search\">
  </form>
  <br>
  <form method=\"post\" action=\"student_add.php?sessionid=$sessionid&callingtype=$callingtype&loginid=$loginid\">
  <input style='margin-left:20px' class='btn btn-primary' type=\"submit\" value=\"Add A New Student\">
  </form>
  ");

// Interpret the query requirements
$q_student_id = $_POST["q_student_id"];
$q_student_lname = $_POST["q_student_lname"];
$q_student_fname = $_POST["q_student_fname"];
$q_student_type = $_POST["q_student_type"];
$q_student_status = $_POST["q_student_status"];


$whereClause = " 1=1 ";

if (isset($q_student_id) and trim($q_student_id)!= "") { 
  $whereClause .= " and sid like '%$q_student_id%'"; 
}

if (isset($q_student_lname) and trim($q_student_lname)!= "") { 
  $whereClause .= " and lname like '%$q_student_lname%'"; 
}

if (isset($q_student_fname) and trim($q_student_fname)!= "") { 
  $whereClause .= " and fname like '%$q_student_fname%'"; 
}

if (isset($q_student_type) and $q_student_type!= "") { 
  $whereClause .= " and stype like '%$q_student_type%'"; 
}

if (isset($q_student_status) and $q_student_status!= "") { 
  $whereClause .= " and status like '%$q_student_status%'"; 
}

// Form the query and execute it
$sql = "select sid, user_id, fname, lname, birthdate, address1, stu_city,  stu_state, stu_zip, stype, status from student where $whereClause order by sid";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

echo "<table class='table table-bordered table-striped' style='margin-left:20px; width:1000px'>";
echo "<tr> <th>Student ID</th> <th>User ID</th> <th>Last Name</th> <th>First Name</th> <th>Birth Date</th> <th>Address</th><th>Type</th> <th>Status</th>  <th>Update</th> </tr>";

// Fetch the result from the cursor one by one
while ($values = oci_fetch_array ($cursor)){
  $sid = $values[0];
  $userid = $values[1];
  $fname = $values[2];
  $lname = $values[3];
  $birthdate = $values[4];
  $address1 = $values[5] . " " . $values[6] . " " . $values[7] . " " . $values[8];  

   if($values[9] == 0)
   {
       $stype= "Undergraudate";
   }
  else
  {
     $stype= "Graudate";
  }
   
   if($values[10] == 1)
   {
       $status= "Probation";
   }
   else
   {
       $status= "Not on Probation";
   }

   echo("<tr>" . 
    "<td>$sid</td> <td>$userid</td> <td>$lname</td> <td>$fname</td><td>$birthdate</td><td>$address1</td><td>$stype</td><td>$status</td>".
    " <td> <A HREF=\"student_update.php?sessionid=$sessionid&sid=$sid&callingtype=$callingtype&loginid=$loginid\">Update</A> </td> ".    
    "</tr>");
}

oci_free_statement($cursor);

echo "</table>";
?>
</body>

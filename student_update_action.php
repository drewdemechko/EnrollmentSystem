<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$callingtype=$_GET["callingtype"];

if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

$loginid =$_GET["loginid"];

// Suppress PHP auto warning.
ini_set( "display_errors", 0);  

// Get input from dept_update.php and update the record.
$sid = trim($_GET["sid"]);   
echo("SID = ". $sid);

$userid = trim($_POST["userid"]);   
$lname = strtoupper(trim($_POST["lname"])); 
$fname = strtoupper(trim($_POST["fname"])); 
$birthdate = strtoupper(trim($_POST["birthdate"])); 
$address1 = strtoupper(trim($_POST["address1"]));
$stu_city = strtoupper(trim($_POST["stu_city"]));
$stu_state = strtoupper(trim($_POST["stu_state"]));
$stu_zip = trim($_POST["stu_zip"]);
$str_type = $_POST["stu_type"];
if(strcasecmp( $str_type,"G") == 0)
	$stype = 1;
else
	$stype = 0;



// the sql string
$sql = "update student set user_id = '$userid', fname = '$fname', lname = '$lname', birthdate = '$birthdate',
             address1= '$address1', stu_city = '$stu_city', stu_state = '$stu_state', stu_zip = '$stu_zip', stype  = '$stype' where sid like '%$sid'";
echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Update Failed.</B> <BR />";

  display_oracle_error_message($cursor);

  die("<i> 

  </i>
  ");
}

// Record updated.  Go back.
Header("Location:admin_add_student.php?sessionid=$sessionid&userid=$loginid&callingtype=$callingtype");
?>
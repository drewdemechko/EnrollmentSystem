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
$userid = $_POST["userid"];
$password = $_POST["password"];
$usertype = $_POST["usertype"];

// the sql string
$sql = "update myuser set password = '$password', usertype = '$usertype' where userid like '$userid'";
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
Header("Location:admin.php?sessionid=$sessionid&userid=$loginid&callingtype=$callingtype");
?>
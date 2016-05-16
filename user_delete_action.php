<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$callingtype =$_GET["callingtype"];

if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

$loginid =$_GET["loginid"];

// suppress php auto warning.
ini_set( "display_errors", 0);  

// obtain input from user_delete.php
$userid = $_POST["userid"];

$sql = "select userid from myusersession where sessionid like '%$sessionid%'";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){ // error unlikely
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if (!($values = oci_fetch_array ($cursor))) {
  // Record already deleted by a separate session.  Go back.
  Header("Location:admin.php?sessionid=$sessionid&callingtype=$callingtype&userid=$loginid");
}
oci_free_statement($cursor);

$current_userid = $values[0];

if($userid == $current_userid)
{
     die("Delete denied!!");

     Header("Location:admin.php?sessionid=$sessionid&callingtype=$callingtype&userid=$loginid");
}

// Form the sql string and execute it.
$sql = "delete from myusersession where userid like '%$userid%'";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){ 
  // Error occured.  Display error-handling interface.
  echo "<B>Deletion Failed.</B> <BR />";

  display_oracle_error_message($cursor);

  die("<i> 

  </i>
  ");
}

// Form the sql string and execute it.
$sql = "delete from myuser where userid = '$userid'";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){ 
  // Error occured.  Display error-handling interface.
  echo "<B>Deletion Failed.</B> <BR />";

  display_oracle_error_message($cursor);

  die("<i> 

  <form method=\"post\" action=\"admin.php?sessionid=$sessionid&callingtype=$callingtype&userid=$loginid\">
  Read the error message, and then try again:
  <input type=\"submit\" value=\"Go Back\">
  </form>

  </i>
  ");
}

// Record deleted.  Go back automatically.
Header("Location:admin.php?sessionid=$sessionid&callingtype=$callingtype&userid=$loginid");
?>

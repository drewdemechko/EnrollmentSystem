<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];

echo ("<BR>sessionid_11:$sessionid"); 

verify_session($sessionid);


// connection OK - delete the session.
$sql = "delete from myusersession where sessionid = '$sessionid'";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];
if ($result == false){
  display_oracle_error_message($cursor);
  die("Session removal failed");
}

// jump to login page
header("Location:login.html");
?>
<?
ini_set( "display_errors", 0);  

include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$callingtype =$_GET["callingtype"];
if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

$loginid =$_GET["loginid"];

$userid = trim($_POST["userid"]);
if ($userid == "")
{
     die("User ID is Required!!");
}
else
{   
    $password = $_POST["password"]; 
    $usertype = $_POST["usertype"];

    // the sql string
    $sql = "insert into myuser values ('$userid', '$password', '$usertype')";

    $result_array = execute_sql_in_oracle ($sql);
    $result = $result_array["flag"];
    $cursor = $result_array["cursor"];

    if ($result == false){
         echo "<BR>Insertion Failed.<BR>";

         display_oracle_error_message($cursor);
  
         die("<i> 

        <form method=\"post\" action=\"user_add?sessionid=$sessionid&loginid=$loginid&callingtype=$callingtype\">

        <input type=\"hidden\" value = \"$userid\" name=\"userid\">
        <input type=\"hidden\" value = \"$password\" name=\"password\">
        <input type=\"hidden\" value = \"$usertype\" name=\"usertype\">
  
        Read the error message, and then try again:
        <input type=\"submit\" value=\"Go Back\">
       </form>
       </i>
        ");
    }

    Header("Location:user_add.php?sessionid=$sessionid&loginid=$loginid&callingtype=$callingtype");
}

?>

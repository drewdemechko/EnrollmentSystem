
<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$wheretocall =$_GET["wheretocall"];

$callingtype=$_GET["callingtype"];

if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

// Suppress PHP auto warning.
ini_set( "display_errors", 0);  

// Get input from dept_update.php and update the record.
$userid = $_POST["userid"];
$currentpassword = $_POST["currentpassword"];
$newpassword= $_POST["newpassword"];
$confirmpassword= $_POST["confirmpassword"];

if($confirmpassword != $newpassword)
{
   die("New password is not mathced");
}
else
{ 
   $sql = "select * from myuser where userid = '$userid'and password = '$currentpassword'";

   $result_array = execute_sql_in_oracle ($sql);
   $result = $result_array["flag"];
   $cursor = $result_array["cursor"];

   if ($result == false){  
      display_oracle_error_message($cursor);
      die("User Query Failed.");
   }

   if($values = oci_fetch_array ($cursor)){
      oci_free_statement($cursor);

      // found the userid
      $userid = $values[0];

        $sql = "update myuser set password = '$newpassword' where userid like '$userid'";

       $result_array = execute_sql_in_oracle ($sql);
       $result = $result_array["flag"];
       $cursor = $result_array["cursor"];

        if ($result == false){
        // Error handling interface.
      	  echo "<B>Update Failed.</B> <BR />";

              display_oracle_error_message($cursor);

            die("<i> 
	
           <form method=\"post\" action=\"user_update?sessionid=$sessionid&callingtype=$callingtype\">
               <input type=\"hidden\" value = \"$dnumber\" name=\"dnumber\">                    
           </form>

           </i>");      
        }

	// Record updated.  Go back.
        if($wheretocall == "admin")
           Header("Location:admin.php?sessionid=$sessionid&userid=$userid&callingtype=$callingtype");
        else if($wheretocall == "student")
          Header("Location:student.php?sessionid=$sessionid&userid=$userid&callingtype=$callingtype");
     }
     else
     {
          echo("<BR>Original Password is not correct!!<BR>");
     }
	
}
   
?>

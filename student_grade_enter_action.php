<?
ini_set( "display_errors", 0);  

include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$callingtype =$_GET["callingtype"];
if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

$loginid =$_GET["loginid"];

    $sid = trim($_POST["q_student_id"]);   
    $seq_id = strtoupper(trim($_POST["q_course_sid"])); 
    $grade = strtoupper(trim($_POST["q_grade"]));     

       $sql = "update Course_taken set grade = '$grade' where sequence_id like '%$seq_id' and student_id like '%$sid'";

    $result_array = execute_sql_in_oracle ($sql);
    $result = $result_array["flag"];
    $cursor = $result_array["cursor"];

     if ($result == false){
               echo "<BR>Grade Update Failed.<BR>";		 
         display_oracle_error_message($cursor);
         die("Client Query Failed.");
     }
 
    oci_free_statement($cursor);

    Header("Location:student_grade_enter.php?sessionid=$sessionid&loginid=$loginid&callingtype=$callingtype");

?>

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
    $password = ($_POST["password"]);
    $usertype = ($_POST["usertype"]);   
    $lname = strtoupper(trim($_POST["lname"])); 
    $fname = strtoupper(trim($_POST["fname"])); 
    $birthdate = strtoupper(trim($_POST["birthdate"])); 
    $address1 = strtoupper(trim($_POST["address1"]));
    $stu_city = strtoupper(trim($_POST["stu_city"]));
    $stu_state = strtoupper(trim($_POST["stu_state"]));
    $stu_zip = trim($_POST["stu_zip"]);
    $str_type = $_POST["stu_type"];
    if(strcasecmp( $str_type,"G") == 0)
	$stu_type = 1;
    else
	$stu_type = 0;

    $stu_status = 0;

    $sql = "insert into myuser values('$userid','$password','$usertype')";
    echo($sql);

    $result_array = execute_sql_in_oracle($sql);
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
      else
    {
        $seqnum = $seqnum + 1;

        $sql = "update StudentID set nextseqno = '$seqnum'";

        echo($sql);

             $result_array = execute_sql_in_oracle_commit($sql);
        $result = $result_array["flag"];
        $cursor = $result_array["cursor"];

        if ($result == false){
                echo "<BR>Insertion Failed into StudentID.<BR>";

                display_oracle_error_message($cursor);

                die("<i>

                <form method=\"post\" action=\"student_add?sessionid=$sessionid&loginid=$loginid&callingtype=$callingtype\">

                <input type=\"hidden\" value = \"$userid\" name=\"userid\">
                <input type=\"hidden\" value = \"$password\" name=\"password\">
                <input type=\"hidden\" value = \"$usertype\" name=\"usertype\">

                Read the error message, and then try again:
                <input type=\"submit\" value=\"Go Back\">
               </form>
               </i>");
        }
       }

     oci_free_statement($cursor);

    $sql = "select nextseqno from StudentID for update";    

    $result_array = execute_sql_in_oracle ($sql);
    $result = $result_array["flag"];
    $cursor = $result_array["cursor"];

     if ($result == false){
         display_oracle_error_message($cursor);
         die("Client Query Failed.");
     }

     $values = oci_fetch_array ($cursor);
     $seqnum = $values[0]; 
       
     $strseq = vsprintf("%06d",$seqnum );

     $sid = $lname[0].$fname[0].$strseq;


    // the sql string
    $sql = "insert into Student values ('$sid','$userid', '$fname','$lname','$birthdate','$address1','$stu_city','$stu_state','$stu_zip','$stu_type','$stu_status')";
    echo($sql);  
 
    $result_array = execute_sql_in_oracle($sql);
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
      else
    {
	$seqnum = $seqnum + 1;

	$sql = "update StudentID set nextseqno = '$seqnum'";

	echo($sql);
	
             $result_array = execute_sql_in_oracle_commit($sql);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];
	
	if ($result == false){
		echo "<BR>Insertion Failed into StudentID.<BR>";

        	display_oracle_error_message($cursor);
  
	        die("<i> 

        	<form method=\"post\" action=\"student_add?sessionid=$sessionid&loginid=$loginid&callingtype=$callingtype\">

	        <input type=\"hidden\" value = \"$userid\" name=\"userid\">
        	<input type=\"hidden\" value = \"$password\" name=\"password\">
	        <input type=\"hidden\" value = \"$usertype\" name=\"usertype\">
  
	        Read the error message, and then try again:
        	<input type=\"submit\" value=\"Go Back\">   
	       </form>
	       </i>");
       	}
       }

     oci_free_statement($cursor);

    Header("Location:student_add.php?sessionid=$sessionid&loginid=$loginid&callingtype=$callingtype");

?>

<html>
<head>
<TITLE>Student Web Page</TITLE> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<style tyep="text/ccs">

header {
    background-color:blue;
    color:white;
    text-align:center;
    padding:5px;	 
}

input[type=text] {
    text-align:center;
    font: 15px arial, sans-serif;
    font-size: 100%
}

input[type=submit] {
    margin:10px;
    font: 15px arial, sans-serif;
    font-size: 100%
}

ul{
    list-style-type: none;
    margin: 4px;
    padding: 0;
    overflow: hidden;
}

li{
    float: right;
    margin: 5px,0; 
    border-right:3px solid #aaa;
}

li:last-child {border-right:0}

.a1 {
    /*display: block;*/
    width: 100px;
    font-weight: bold;
    color: #FFFFFF;
    background-color: #98bf21;
    text-align: center;
    padding: 10px 10px;
    text-decoration: none;
    /*text-transform: uppercase;*/
    font: 15px arial, sans-serif;
    font-size: 120%
}


.a1:link, .a1:visited{
    /*display: block;*/
    width: 100px;
    font-weight: bold;
    color: #FFFFFF;
    background-color: #98bf21;
    text-align: center;
    padding: 10px 10px;
    text-decoration: none;
    /*text-transform: uppercase;*/
    font: 15px arial, sans-serif;
    font-size: 150%
}


.a1:hover, a1:active {
    background-color: #7A991A;
}


.button {
   padding: 5px 5px 5px 2px;
   text-align: center;
   margin: 10px;
   font: 15px arial, sans-serif;
   font-size: 100%
}

.button:hover {
  background: darkgray;
}


table, th, td{
  border: 1px solid darkgray;
}

table{
  border-collapse:collapse;
  font: 15px arial, sans-serif;
  margin:10px;
}

th{
  text-align:center;
  vertical-align:center;
  height:35px; 
  padding:5px,5px;
}

tr{
  width: 100%
}

td{
  text-align:center;
  vertical-align:center;
  height:30px; 
  width:120px;
  padding:5px,5px;
}

</style>

</head>

<body>
<header>
<h1>Web-Based User Management System -Enrollment Result</h1>
</header>

<?
ini_set( "display_errors", 0);  

include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$callingtype =$_GET["callingtype"];
if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

$loginid =$_SESSION["loginid"];
$userno =$_GET["userno"];

$gstudent_id =$_GET["student_id"];
$regArray = $_POST["selectCourse"];
$cnt = 0;

echo("<ul>
  <li><a class = \"a1\" href=\"student_enrollment.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype=$callingtype&student_id=$gstudent_id&userno=$userno\">Go Back</a></li>
  </ul>");

foreach($regArray as $regValue)
{
        $sql = "select cno from Course where seq_id = '$regValue'";

	$result_array = execute_sql_in_oracle ($sql);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];

	if ($result == false){
	  display_oracle_error_message($cursor);
	  die("Client Query Failed.");
	}

	$values = oci_fetch_array ($cursor);
	$registering_course = $values[0];

	oci_free_statement($cursor);	

        if($cnt === 0)
	{
		$sql = "drop view Course_taken_info";

		$result_array = execute_sql_in_oracle_no_error_chk($sql);
		$result = $result_array["flag"];
		$cursor = $result_array["cursor"];
	       
		oci_free_statement($cursor);	

		$sql = "create view Course_taken_info as select seq_id, cno, grade " .
                            "from Course JOIN Course_taken ON seq_id = sequence_id " .
                            "where student_id like '$gstudent_id'";

	        //create view Course_taken_info as select seq_id, cno from Course JOIN Course_taken ON seq_id = sequence_id where student_id like 'JL000001';

		$result_array = execute_sql_in_oracle ($sql);
		$result = $result_array["flag"];
		$cursor = $result_array["cursor"];

		if ($result == false){	
		  display_oracle_error_message($cursor);
		  oci_free_statement($cursor);
		  die("Client Query Failed.");
		}

		oci_free_statement($cursor);
		$cnt = $cnt+1;
        }

	$sql = "select * from Course_taken_info CI where exists(select * from Course C where seq_id = '$regValue' and CI.cno = C.cno)";

	$result_array = NULL;
	$result_array = execute_sql_in_oracle ($sql);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];

	if ($result == false){
	  display_oracle_error_message($cursor);
	  die("Client Query Failed.");
	}

	$values = NULL;
	$values = oci_fetch_array ($cursor);
	oci_free_statement($cursor);	

	if($values)  // already taken course
        {	
             echo("<br><h4>** Register Fail ($regValue,$values[1]) : $values[1] has been already taken</h4>");	     
             continue;
	}

	// check prerequisite  

	$sql = "select * from Prerequisite " .
                "where base_cno like '$registering_course' and not exists( select * from Course_taken_info " .
                                 "where  prereq_cno = cno and grade is not NULL)";
                                                                    
	$result_array = execute_sql_in_oracle ($sql);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];

	if ($result == false){
	  display_oracle_error_message($cursor);
	  die("Client Query Failed.");
	}
	        
	$values = NULL;
	$preCourse = NULL;

	while ($values = oci_fetch_array ($cursor)){
		if(isset($preCourse))            
			$preCourse = $preCourse . ",". $values[1];		   	
		else
			$preCourse = $values[1];		   	
		$values = NULL;
	}        

        oci_free_statement($cursor);

	if(isset($preCourse)) 
	      echo("<br><h4>** Register Fail ($regValue) : the following prerequisit course must be needed [ $preCourse ]</h4>");
        else
	{
	      // check remained seat
	      $sql = "select remained_seat from Course where seq_id = '$regValue' for update";

              $result_array = execute_sql_in_oracle($sql);
              $result = $result_array["flag"];
              $cursor = $result_array["cursor"];

              if ($result == false){
		  display_oracle_error_message($cursor);
		  die("Client Query Failed.");
	      }

	          $values = NULL;
	      $values = oci_fetch_array ($cursor);
	      $rseat = $values[0];
	 
              if($rseat > 0)
	      {
  		  oci_free_statement($cursor);
		  $rseat = $rseat - 1;
	 	  $sql = "update Course set remained_seat = '$rseat' where seq_id = '$regValue'";

 	          $result_array = execute_sql_in_oracle_commit($sql);
                  $result = $result_array["flag"];
                  $cursor = $result_array["cursor"];
		  if ($result == false){
		  	display_oracle_error_message($cursor);
	   	        die("Client Query Failed.");
	          }

		  oci_free_statement($cursor);	

		   // insert into Course_taken
                  $sql = "insert into Course_taken values ('$regValue','$gstudent_id',NULL)";

                  $result_array = execute_sql_in_oracle_commit($sql);
                  $result = $result_array["flag"];
                  $cursor = $result_array["cursor"];
		
                  echo("<br><h4>** Successfuly registered ($regValue : $registering_course)</h4>");	

		  if ($result == false)
		  {
  			display_oracle_error_message($cursor);

			oci_free_statement($cursor);

			$sql = "drop view Course_taken_info";

			$result_array = execute_sql_in_oracle_commit;($sql);
			$result = $result_array["flag"];
			$cursor = $result_array["cursor"];
	
			oci_free_statement($cursor);

	   	        die("Client Query Failed.");
	          }

		    oci_free_statement($cursor);

	       }
	      else
	      {
  		  echo("<br><h4>** Register Fail ($regValue : $registering_course) : No Seat available</h4>");	
                  $result_array = execute_sql_in_oracle_rollback();                  
		  oci_free_statement($cursor);
              }

	}
}
?>
</body>
</html>

<html>
<head>
    <TITLE>student Web Page</TITLE> 
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
  width:100px;
  padding:5px,5px;
}

</style>
</head>

<body>
<header>
	<h1>Web-Based User Management System - Student</h1>
</header>

<?
    include "utility_functions.php";

	$sessionid =$_GET["sessionid"];
	verify_session($sessionid);
	$loginid=$_GET["userid"];

	$wheretocall = "student";
	$callingtype=$_GET["callingtype"];

	if($callingtype == NULL)
		$callingtype = 1;	  // 1: admin or student , 2 : student-admin


	// Here we can generate the content of the welcome page
	if($callingtype == 1)
	{
   echo("<ul>
        <li><a class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
		<li><a class = \"a1\" href=\"change_password.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Change Password</a></li>
		<li><a class = \"a1\" href=\"student_info.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Student Information</a></li>
	    <li><a class = \"a1\" href=\"student_record.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Student Record</a></li>
		<li><a class = \"a1\" href=\"course_info.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">About Courses</a></li>
		<li><a class = \"a1\" href=\"enroll.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Enroll Classes</a></li>
		</ul>");
	}
	else
	{
echo("<br><BR> callingtype : $callingtype");
		 echo("<ul>
        <li><a class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
		<li><a class = \"a1\" href=\"change_password.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Change Password</a></li>
		<li><a class = \"a1\" href=\"student_info.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Student Information</a></li>
	    <li><a class = \"a1\" href=\"student_record.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Student Record</a></li>
		<li><a class = \"a1\" href=\"course_info.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">About Courses</a></li>
		<li><a class = \"a1\" href=\"enroll.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Enroll Classes</a></li>
		<li><a class = \"a1\" href=\"admin.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Administrator</a></li>
		</ul>");
	}
  //list box for choosing semester to see courses  
	echo ("<br><br><br><form  id=\"see-courses\" method=\"post\" target = \"_self\" action =\"enroll.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\" > " .
			"<select name=\"semester\" margin-left = 2%> " .
				"<option value=\" \">select a semester</option> " .
				"<option value=\"2015 Fall\">2015 Fall</option> " .
			   	"<option value=\"2015 Spring\">2015 Spring</option> " .
				"<input type=\"submit\" value = \"confirm\"> " .
			"</select> " .	
		  "</form>");
		  
	$semester=$_POST["semester"];
	
	
//query for acquiring student ID, sequence # and grade;
	$sql = "select Student.sid from Student JOIN myuser on student.user_id = myuser.userid where Student.user_id like '$loginid'";
	
	$result_array = execute_sql_in_oracle ($sql);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];
	
	if ($result == false){
		display_oracle_error_message($cursor);
		die("Client Query Failed.");
	}
	 
	$values_student = oci_fetch_array ($cursor);
	$student = $values_student[0];	
	oci_free_statement($cursor);
    oci_free_statement($cursor);
	
	echo("<form  id=\"search_courses\" method=\"post\" action =\"enroll_action.php?student=$student&semester=$semester&sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\" > " .
				"<input type=\"submit\" value = \"Click here for Class Search\"> " .
		  "</form>");
		  
	
   if( $semester != NULL){
			
        //query for acquiring student taking and taken courses data	
		$sql1 = "select CT.sequence_id, C.cno,C.classtime  from Course_taken  CT JOIN  Course C where CT.student_id like '$student' ".
                "and C.semester like '$semester'";
		
		$result_array = execute_sql_in_oracle ($sql1);
		$result = $result_array["flag"];
		$cursor = $result_array["cursor"];
		$i=0;
		while($values = oci_fetch_array($cursor)){
				$seq_id[$i] = $values[0];       echo" sequence id : $seq_id<br>";
				$course_num[$i]= $values[1];
				$classtime[$i] = $values[2];
		
				$i++;
		}
		echo("<h4> Current Schedule </h4>");
		echo("<hr color = \"#888888\" align=\"left\" width=\"50%\">");
		
		echo "<table>";
		echo "<tr BGCOLOR=\"#E0EBEB\"> <th>Semester</th> <th>Sequence ID</th> <th>Course NO</th> <th>Credit</th> <th>Title</th><th>Class Time</th></tr>";
		$total_hour =0;
		echo("<h4> Total Credit Hours : $total_hour <BR>");
		echo(" Date: "); 
		echo date(DATE_RFC850) . "<br>";
	}
	oci_free_statement($cursor);
	echo "</table>";
?>
</body>
</html>




















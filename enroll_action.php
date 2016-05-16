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

	$semester =$_GET["semester"];
	
	$student =$_GET["student"];
	
	$wheretocall = "student";
	$callingtype=$_GET["callingtype"];

	if($callingtype == NULL)
		$callingtype = 1;	  // 1: admin or student , 2 : student-admin


// menu in navigation bar

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

	echo("<h3> $semester Courses </h3>");
	echo("<hr color = \"#888888\" align=\"left\" width=\"78%\">");
	echo"<h3> Look up classes to Add </h3>";	
	echo "<table>";
	echo "<tr BGCOLOR=\"#E0EBEB\"><th> <th>Semester</th> <th>Sequence ID</th> <th>Course NO</th> <th>Credit</th> <th>Title</th><th>Class Time</th>".
	     "<th>Cap</th><th>Act</th><th>Rem</th></tr>";

//register submit button	
	echo("<form  id=\"register\" method=\"post\" action =\"enroll_action.php?student=$student&semester=$semester&sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\" > " .
				"<input type=\"submit\" value = \"Click here for register\"> " .
		  "</form>");
	
//courses search for the semester and let the student select 
	$sql1 = "select C.seq_id, C.cno,CD.credit, CD.title, C.classtime, C.max_seat ".
	        "from Course C JOIN Course_description CD on C.cno = CD.course_no ".
			"where C.semester like '$semester'";
	
	$result_array = execute_sql_in_oracle ($sql1);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];

	if ($result == false){
		display_oracle_error_message($cursor);
		die("Client Query Failed.");
	}
	$i=0;
	while($values = oci_fetch_array($cursor)){
				$seq_id[$i] = $values[0];  
				$course_num[$i]= $values[1];  
				$course_credit[$i] = $values[2]; 
				$ctitle[$i]= $values[3];
				$classtime[$i] = $values[4]; 
				$max_seat[$i] = $values[5]; 
				$i++;  
							
			}
	oci_free_statement($cursor);
	$k=0;
	while($k<$i){
				$sql1 = "select count(*) from Course_taken where sequence_id like '$seq_id[$k]' and grade = NULL";     	        
	
				$result_array = execute_sql_in_oracle ($sql1);
				$result = $result_array["flag"];
				$cursor = $result_array["cursor"];

				if ($result == false){
				display_oracle_error_message($cursor);
				die("Client Query Failed.");
				}
				$values = oci_fetch_array($cursor);
				$cap_seat[$k] = $values[0];
				$remain_seat[$k] = $max_seat[$k] - $cap_seat[$k];
				 $k++;  
				oci_free_statement($cursor);
	}
	$l=0;
	while($l<$i){
				echo("<tr>" . 
					" <td><input type=\"checkbox\" id=\"myCheck\"></td><td>$semester</td><td>$seq_id[$l] </td>  <td>$course_num[$l]</td> " .
					" <td>$course_credit[$l]</td> <td>$ctitle[$l]</td> <td>$classtime[$l]</td> <td>$max_seat[$l]</td> <td>$cap_seat[$l]</td> <td>$remain_seat[$l]</td> </tr>");
				echo"<BR>";	 $l++;
	
	}
	
		$sql_course_of_the_Semester = "select Course.cno, CD.title, CD.credit from Course JOIN Course_description CD on Course.cno = CD.course_no where $whereClause"; 
		
		$result_array = execute_sql_in_oracle ($sql_course_of_the_Semester); 
		$result = $result_array["flag"]; 
		$cursor = $result_array["cursor"]; 
		
		
		$i=0;
		$cno[] = "";
		$title[]= "";
		$credit[]= 0;
		while ($values = oci_fetch_array ($cursor)){
			$cno[$i] = $values[0];
			$title[$i] = $values[1];
			$credit[$i] = $values[2];
			$i++;
	    }
		oci_free_statement($cursor);
	
		echo "<BR><h3>   </h3> ";
	    echo "<table>";
	    echo "<tr> <th COLSPAN=6>*Courses*</th>check box</tr>  <tr><th>Semester</th><th>Course no</th><th>Title</th><th>Credit</th><th>prerequisites</th></tr>";
	    $j=0;
		echo"<tr><td ROWSPAN=$i+1 BGCOLOR=\"#E0EBEB\">$semester</td>";
		while($cno[$j]) {
			echo"<td><form action=\"add_course.php\" method=\"get\ multiple"> " .
				"<input type=\"checkbox\" name=\"crn\" value=$cno[$j]> " .
				"</form>";


			echo"<td>$cno[$j]</td> <td>$title[$j]</td> <td>$credit[$j]</td> ";
			
			$sql_pre = "select prereq_cno from Prerequisite where base_cno like '%$cno[$j]%'";
			$result_array = execute_sql_in_oracle ($sql_pre); 
			$result = $result_array["flag"]; 
			$cursor = $result_array["cursor"];
			
			$k=0;
			while ($values = oci_fetch_array ($cursor)){
					$prerequite[$k] = $values[0];
					$k++;
			}
			if($prerequite[0] == NULL) 
					echo"<td> no prerequisites </td></tr>"; 
			else {
					$l=0; echo "<td>";
					while($prerequite[$l]){
							echo " <br>$prerequite[$l]  "; 
							$l++;
					}
					echo "</td></tr>";
				}
				
			$j++;
			oci_free_statement($cursor);
		}*/
	oci_free_statement($cursor);
	echo "</table>";
?>
</body>
</html>
					

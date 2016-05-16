<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<TITLE>Student Web Page</TITLE> 
</head>

<body>

<nav class="navbar navbar-inverse" style="background-color:rgb(40,95,143); margin-bottom:0">
    <div class="container-fluid">
        <div class="navbar-header">
			<div class="navbar-brand">
                <img src="http://busn.uco.edu/bahouth/UCO.jpg" style="position: absolute; width: 50px; height: 50px; left: 0; top: 0; border-radius: 5px;"/>
            </div>
            <div class="navbar-brand" style="color:white;margin-left: 30px">
                Student Enrollment <i class="glyphicon glyphicon-copyright-mark"></i>
            </div>
        </div>
    </div>
</nav>

<?
    include "utility_functions.php";

	$sessionid =$_GET["sessionid"];
	verify_session($sessionid);
  
	$loginid=$_GET["userid"];
	$userno=$_GET["userno"];


	$wheretocall = "student";
	$callingtype=$_GET["callingtype"];

	if($callingtype == NULL)
		$callingtype = 1;	  // 1: admin or student , 2 : student-admin

	// Here we can generate the content of the welcome page

	if($callingtype == 1)
	{

   echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
		<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
      <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"change_password.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Change Password</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_info.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Student Information</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_record.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Student Record</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"course_info.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">About Courses</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_enrollment.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Enroll Classes</a></li>
		</ul>
			</div>");
	}
	else
	{

	echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
		<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
      <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"change_password.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Change Password</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_info.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Student Information</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_record.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Student Record</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"course_info.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">About Courses</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_enrollment.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Enroll Classes</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"admin.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno\">Administrator</a></li>
		</ul>
			</div>");
	}
 
// query semester
$sql = "select semester from Course";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}
else
{
   $idx = 0;
   while (	$values = oci_fetch_array ($cursor)){
			$tsemester[$idx] = $values[0];
			$idx = $idx + 1;
   }
}

oci_free_statement($cursor);

//============= display drop-down box of semester ===========================================================//

echo("<form style='margin-left:20px; margin-top:20px' method=\"post\" target = \"_self\" action=\"course_info.php?sessionid=$sessionid&callingtype=$callingtype&semester=$q_semester&student_id=$gstudent_id&userid=$loginid&userno=$userno\">");
echo("<p> Semester : <select name = \"semester\"><option selected>Choose Semester</option>");

	echo("<option>$tsemester[0]</option>");
	for($i = 1; $i < $idx; ++$i) {		     
            if( $tsemester[$i] != $tsemester[$i-1])
					echo("<option>$tsemester[$i]</option>");
	}       
echo("</select>");
echo("<input style='margin-left:10px' class='btn btn-primary' type=\"submit\" value=\"Course Search\"> </p>");
echo("</form>");

 	

  if(isset($_POST["semester"])){
	
		$semester = $_POST["semester"];
		
		
	
		$sql_course_of_the_Semester = "select C.semester,C.seq_id,C.cno, CD.title,CD.credit,C.classtime ".
									"from Course C JOIN Course_description CD on C.cno = CD.course_no where C.semester like '$semester'"; 
				
		$result_array = execute_sql_in_oracle ($sql_course_of_the_Semester); 
		$result = $result_array["flag"]; 
		$cursor = $result_array["cursor"]; 
		
		
		echo "<table class='table table-bordered' style='margin-left:20px; width:600px'>";
	   	echo "<tr><h3> <th COLSPAN=6>*Courses*</th></tr>  <tr BGCOLOR = \"#FFFF99\"><th>Semester</th><th>Sequence ID</th><th>Course no</th><th>Title</th><th>Credit</th><th>Classtime</th></h3></tr>";
	  	echo"<tr><td ROWSPAN=$idx BGCOLOR=\"#E0EBEB\">$semester</td>";
		
		while ($values = oci_fetch_array ($cursor)){
			
			echo"<td>$values[0]</td><td>$values[1]</td> <td>$values[2]</td> <td>$values[3]</td> <td>$values[4]</td></tr> ";
		}
		oci_free_statement($cursor);
	}
	echo "</table>";
?>
</body>
</html>

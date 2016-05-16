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
   
	$loginid=$_SESSION["loginid"];
	$userno=$_GET["userno"];

	$wheretocall = "student";
	$callingtype=$_GET["callingtype"];

	$gstudent_id=$_GET["student_id"];


	if($callingtype == NULL)
		$callingtype = 1;	  // 1: admin or student , 2 : student-admin

	// Here we can generate the content of the welcome page
	if($callingtype == 1)
	{

         echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
		<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
       		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"change_password.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Change Password</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_info.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Student Information</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_record.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Student Record</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"course_info.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">About Courses</a></li>
		<li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_enrollment.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Enroll Classes</a></li>
		</ul>
			</div>");
	}
	else
	{

	echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
		<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
              <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
	         <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"change_password.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Change Password</a></li>
	         <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_info.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Student Information</a></li>
	      <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_record.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Student Record</a></li>
	         <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"course_info.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">About Courses</a></li>
	         <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"student_enrollment.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Enroll Classes</a></li>
	         <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"admin.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype&userno=$userno&student_id=$gstudent_id\">Administrator</a></li>
	         </ul>
			</div>");
	}

		
//query for acquiring student ID, sequence # and grade;
	$sql = "select Student.sid from Student JOIN myuser on student.user_id = myuser.userid where Student.user_id like '%$loginid%'";
	
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
	
 //query for acquiring student taking and taken courses data	
	$sql1 = "select CT.sequence_id, C.cno, CD.title,C.semester,CD.credit,CT.grade ".
	        "from Course_taken CT JOIN Course C on CT.sequence_id = C.seq_id JOIN Course_description CD on CD.course_no = C.cno ".
			"where CT.student_id like '%$student%'";
	
	$result_array = execute_sql_in_oracle ($sql1);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];

	if ($result == false){
		display_oracle_error_message($cursor);
		die("Client Query Failed.");
	}
	
 
	echo "<br><table border=1 style='margin-left:20px'>";
	echo "<tr BGCOLOR=\"#E0EBEB\"> 
			<th>sequence ID</th> <th>course NO</th> <th>course title</th> <th>semester</th> <th>credits</th> <th>grade</th> 
	      </tr><br><br><br>";
		  
  
	// Fetch the result from the cursor one by one	
   	$total_credit = 0;
	$tot_grade =0 ;	
	$g = 0;
	$GPA = 0;
	while ($values = oci_fetch_array ($cursor)){
			$seqenceid = $values[0]; 
			$courseno = $values[1];
			$title = $values[2];   
			$semester = $values[3]; 
			$credit = $values[4];
			$grade = $values[5];
		
			echo("<tr>" . 
				"<td>$seqenceid </td><td>$courseno</td> <td>$title</td> " .
				"<td>$semester</td> <td>$credit</td> <td>$grade</td> " .
				"</tr>");
			
					
			if( $grade != NULL ) {
				switch($grade){
					case 'A': 
						$g = 4.0;  break;
					case 'B': 
						$g = 3.0;  break;
					case 'C': 
						$g = 2.0; break;
					case 'D': 
						$g = 1.0; break;
					case 'F': 
						$g = 0.0;  break;
				}
				$total_credit = $total_credit + $credit;
				$tot_grade = $tot_grade + ($g * $credit);
			 }   
		
	}
    oci_free_statement($cursor);

	
	$GPA = $tot_grade / $total_credit;
	
	echo("<tr >" . 
	        "<td colspan = 5><h3>Total credits of completed courses</h3> </td><td>$total_credit</td> </tr>" .
	        "<tr >" .
	        "<td colspan = 5><h3>*     GPA     * </h3></td> <td>$GPA</td></tr>");
	
	echo "</table>";

?>
</body>
</html>

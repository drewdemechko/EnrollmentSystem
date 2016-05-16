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
	
	$sql = "select * from Student where Student.user_id like trim('$userno')";


	$result_array = execute_sql_in_oracle ($sql);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];

	if ($result == false){
		display_oracle_error_message($cursor);
		die("Client Query Failed.");
	} 
	echo "<br><br>";
	
	echo "<table border=1 style='margin-left:20px'>";
	echo "<tr BGCOLOR=\"#E0EBEB\"> <th>student ID</th> <th>Last Name</th> <th>First Name</th> <th>Birth Date</th> <th>Age</th> <th>Address</th> ".
         "<th>State</th> <th>Zip</th><th>Student Type</th> <th>Probation</th> </tr>";
// Fetch student information from the cursor one by one

    
	while ($values = oci_fetch_array ($cursor)){
		$sid = $values[0];  
		$fname = $values[2];  
		$lname = $values[3];
		$birthdate = $values[4]; 
		$address1 = $values[5];  
		$stu_city = $values[6];  
		$stu_state = $values[7]; 
		$stu_zip = $values[8]; 
		
		if($values[9] == 1)  
					$stype='Graduate' ;
		else		
					$stype ='Undergraduate';
					
		if($values[10] == 1 )  
					$status = 'Probation';
		else		
					$status = 'Not on Probation';
	
	$tempDOB = $birthdate[6] . $birthdate[7] . $birthdate[8] . $birthdate[9]
	. '-' . $birthdate[0] . $birthdate[1] . '-' . $birthdate[3] . 
	$birthdate[4];
        $from = new DateTime($tempDOB);
        $to = new DateTime('today');
	$age = $from->diff($to)->y;
		echo("<tr>". 
			"<td>$sid</td> <td>$lname</td> <td>$fname</td> ".
			"<td>$birthdate</td> <td>$age</td> <td>$address1 $stu_city</td> ".
			"<td>$stu_state</td>  <td>$stu_zip</td> <td>$stype</td> ".
			"<td>$status</td></tr>");
	}

oci_free_statement($cursor);
echo "</table>";
echo "</div>";

?>
</body>
</html>

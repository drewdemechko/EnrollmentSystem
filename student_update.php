<head>

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

input[type=reset] {
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

</style>
</head>

<body>
<header>
<h1>Web-Based User Management System - Student Info Update</h1>
</header>

<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$callingtype=$_GET["callingtype"];

$loginid =$_GET["loginid"];

if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

echo("<ul>
  <li><a class = \"a1\" href=\"admin_add_student.php?sessionid=$sessionid&userid=$loginid&callingtype=$callingtype\">Go Back</a></li>
  </ul>");

// Verify how we reach here
if (!isset($_POST["update_fail"])) { // from welceomepage.php
  // Get the dnumber, fetch the record to be updated from the database 
  $q_sid = $_GET["sid"];

  // the sql string
  $sql = "select sid, user_id, fname, lname, birthdate, address1, stu_city,  stu_state, stu_zip, stype, status from student where sid like '%$q_sid'";

  $result_array = execute_sql_in_oracle ($sql);
  $result = $result_array["flag"];
  $cursor = $result_array["cursor"];

  if ($result == false){
    display_oracle_error_message($cursor);
    die("Query Failed.");
  }

  $values = oci_fetch_array ($cursor);
  oci_free_statement($cursor);

  $sid = $values[0];
  $userid = $values[1];
  $fname = $values[2];
  $lname = $values[3];
  $birthdate = $values[4];
  $address1 = $values[5];
   $stu_city = $values[6];
   $stu_state =$values[7];
   $stu_zip = $values[8];  

   if($values[9] == 0)
   {
           $stype = "<select name = \"stu_type\"><option value=\"U\" selected >Undergraduate</option><option value=\"G\">Graduate</option> </select>";
   }
  else
  {
        $stype = "<select name = \"stu_type\"> <option value=\"U\" >Undergraduate</option><option value=\"G\" selected>Graduate</option> </select>";
  }
   
   if($values[10] == 1)
   {
       $status= "Probation";
   }
   else
   {
       $status= " ";
   }
}
else { // from update_action.php
  // Get the values of the record to be updated directly
  $userid = $_POST["userid"];
  $password = $_POST["password"];
  $usertype = $_POST["usertype"];
}

// display the record to be updated.  

echo("
  <br><br>
  <form method=\"post\" action=\"student_update_action.php?sessionid=$sessionid&loginid=$loginid&callingtype=$callingtype&sid=$sid\">
  <p>Student ID : <input type=\"text\" value = \"$sid\" size=\"8\" maxlength=\"8\" name=\"sid\" disabled><br><br>
  Last Name : <input type=\"text\" value = \"$lname\" size=\"15\" maxlength=\"15\" name=\"lname\" required><br><br>
  First Name : <input type=\"text\" value = \"$fname\" size=\"15\" maxlength=\"15\" name=\"fname\" required><br><br>
  Birth Date (YYYY-MM-DD) : <input type=\"text\" value = \"$birthdate\" size=\"10\" maxlength=\"10\" name=\"birthdate\" required><br><br></p>
  
   <p> Address1 : <input type=\"text\" value = \"$address1\" size=\"30\" maxlength=\"30\" name=\"address1\"><br><br>
   City : <input type=\"text\" value = \"$stu_city\" size=\"10\" maxlength=\"15\" name=\"stu_city\"><br><br>
   State : <input type=\"text\" value = \"$stu_state\" size=\"2\" maxlength=\"2\" name=\"stu_state\"><br><br>
   Zip Code : <input type=\"text\" value = \"$stu_zip\" size=\"5\" maxlength=\"5\" name=\"stu_zip\"><br><br>
     Student Type : . $stype. </p>
   <input type=\"submit\" value=\"Update\">
  </form>
   ");

?>
</body>

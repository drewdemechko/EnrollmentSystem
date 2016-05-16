<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<TITLE>Administrator Web Page</TITLE> 
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

/*
.button {
  //padding: 5px 5px 5px 25px;
  border: 1px solid #666;
  color:#000;
  text-decoration:none;  
   font-size: 150%;
   height: auto;
   width: auto;
   text-align: center;
   margin: 10px,10px;
}

.button:hover {
  background: darkgray;
}
*/

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
<nav class="navbar navbar-inverse" style="background-color:rgb(40,95,143)">
    <div class="container-fluid">
        <div class="navbar-header">
			<div class="navbar-brand">
                <img src="http://busn.uco.edu/bahouth/UCO.jpg" style="position: absolute; width: 50px; height: 50px; left: 0; top: 0; border-radius: 5px;"/>
            </div>
            <div class="navbar-brand" style="color:white;margin-left: 30px">
                Student Enrollment <i class="glyphicon glyphicon-copyright-mark"></i>
    </div>
</nav>

<? 
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);
$callingtype=$_GET["callingtype"];

if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

if($callingtype == 1)
{
   echo("<ul>
        <li><a class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
        <li><a class = \"a1\" href=\"change_password.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Change Password</a></li>
        <li><a class = \"a1\" href=\"student_grade_enter.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Enter Student Grade</a></li>
        <li><a class = \"a1\" href=\"admin_add_student.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Add a new student</a></li>
        <li><a class = \"a1\" href=\"admin_search_student_by_courseno.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">List students by Course No</a></li>
        </ul>");
}
else
{
   echo("<ul>
       <li><a class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
       <li><a class = \"a1\" href=\"change_password.php?sessionid=$sessionid&loginid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Change Password</a></li>
       <li><a class = \"a1\" href=\"student.php?sessionid=$sessionid&userid=$loginid&wheretocall=$wheretocall&callingtype=$callingtype\">Student</a></li>
       </ul>");
}

echo("<br><br>
  <form method=\"post\" action=\"admin.php?sessionid=$sessionid&userid=$loginid&callingtype=$callingtype\">
  UserID: <input type=\"text\" size=\"8\" maxlength=\"8\" name=\"q_userid\"> 
  UserType (0:Student, 1:Admin, 2: Student-Admin): <input type=\"text\" size=\"2\" maxlength=\"1\" name=\"q_usertype\">
  <input type=\"submit\" value=\"Search\">
  </form>
  <br>
  <form method=\"post\" action=\"user_add.php?sessionid=$sessionid&callingtype=$callingtype&loginid=$loginid\">
  <input type=\"submit\" value=\"Add A New User\">
  </form>
  ");

// Interpret the query requirements
$q_userid = $_POST["q_userid"];
$q_usertype = $_POST["q_usertype"];


$whereClause = " 1=1 ";

if (isset($q_userid) and trim($q_userid)!= "") { 
  $whereClause .= " and userid like '%$q_userid%'"; 
}

if (isset($q_usertype) and $q_usertype!= "") { 
  $whereClause .= " and usertype like '%$q_usertype%'"; 
}

// Form the query and execute it
$sql = "select userid, password, usertype from myuser where $whereClause order by userid";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

echo "<table border=1>";
echo "<tr> <th>User ID</th> <th>Password</th> <th>User Type</th> <th>Update</th> <th>Delete</th> <th>Reset Password</th> </tr>";

// Fetch the result from the cursor one by one
while ($values = oci_fetch_array ($cursor)){
  $userid = $values[0];
  $password = $values[1];
  $usertype = $values[2];
  echo("<tr>" . 
    "<td>$userid</td><td>$password</td> <td>$usertype</td> ".
    " <td> <A HREF=\"user_update.php?sessionid=$sessionid&userid=$userid&callingtype=$callingtype&loginid=$loginid\">Update</A> </td> ".
    " <td> <A HREF=\"user_delete.php?sessionid=$sessionid&userid=$userid&callingtype=$callingtype&loginid=$loginid\">Delete</A> </td> ".
      " <td> <A HREF=\"reset_password.php?sessionid=$sessionid&userid=$userid&callingtype=$callingtype&loginid=$loginid\">Reset</A> </td> ".
    "</tr>");
}

oci_free_statement($cursor);

echo "</table>";

?>
</body>

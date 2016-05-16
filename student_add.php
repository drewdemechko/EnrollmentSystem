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

<header>
<h1>Web-Based User Management System - Add New Student</h1>
</header>


<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$callingtype =$_GET["callingtype"];
if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

$loginid =$_GET["loginid"];

if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

echo("<ul>
  <li><a class = \"a1\" href=\"admin_add_student.php?sessionid=$sessionid&userid=$loginid&callingtype=$callingtype\">Go Back</a></li>
  </ul>");

echo("
  <br><br>
  <form method=\"post\" action=\"student_add_action.php?sessionid=$sessionid&loginid=$loginid&callingtype=$callingtype\">
    Login id : <input type='text' value='$userid' size='15' maxlength='15' name='userid' required><br><br>
    Password : <input type='text' value='$password' size='15' maxlength='15' name='password' required><br><br>
    User type : <input type='text' value='$usertype' size='15' maxlength='15' name='usertype' required> (0 student or 1 for student admin)<br><br>    
    Last Name : <input type=\"text\" value = \"$lname\" size=\"15\" maxlength=\"15\" name=\"lname\" required><br><br>
  First Name : <input type=\"text\" value = \"$fname\" size=\"15\" maxlength=\"15\" name=\"fname\" required><br><br>
   Birth Date (YYYY-MM-DD) : <input type=\"text\" value = \"$birthdate\" size=\"10\" maxlength=\"10\" name=\"birthdate\" required><br><br></p>
  
   <p> Address1 : <input type=\"text\" value = \"$address1\" size=\"30\" maxlength=\"30\" name=\"address1\"><br><br>
   City : <input type=\"text\" value = \"$stu_city\" size=\"10\" maxlength=\"15\" name=\"stu_city\"><br><br>
   State : <input type=\"text\" value = \"$stu_state\" size=\"2\" maxlength=\"2\" name=\"stu_state\"><br><br>
   Zip Code : <input type=\"text\" value = \"$stu_zip\" size=\"5\" maxlength=\"5\" name=\"stu_zip\"><br><br>
   Student Type : <select name = \"stu_type\"> <option value=\"U\">Undergraduate</option><option value=\"G\">Graduate</option> </select></p>
   <input type=\"submit\" value=\"Add\">
  </form>
   ");

?>

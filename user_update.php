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
<h1>Web-Based User Management System - User Info Update</h1>
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
  <li><a class = \"a1\" href=\"admin.php?sessionid=$sessionid&userid=$loginid&callingtype=$callingtype\">Go Back</a></li>
  </ul>");

// Verify how we reach here
if (!isset($_POST["update_fail"])) { // from welceomepage.php
  // Get the dnumber, fetch the record to be updated from the database 
  $q_userid = $_GET["userid"];

  // the sql string
  $sql = "select userid, password, usertype from myuser where userid like '%$q_userid'";

  $result_array = execute_sql_in_oracle ($sql);
  $result = $result_array["flag"];
  $cursor = $result_array["cursor"];

  if ($result == false){
    display_oracle_error_message($cursor);
    die("Query Failed.");
  }

  $values = oci_fetch_array ($cursor);
  oci_free_statement($cursor);

  $userid = $values[0];
  $password = $values[1];
  $usertype = $values[2];
}
else { // from update_action.php
  // Get the values of the record to be updated directly
  $userid = $_POST["userid"];
  $password = $_POST["password"];
  $usertype = $_POST["usertype"];
}

// display the record to be updated.  
echo("
   <br>
   <br>
  <form method=\"post\" action=\"user_update_action.php?sessionid=$sessionid&loginid=$loginid&callingtype=$callingtype\">
  Userid (Read-only): <input type=\"text\" readonly value = \"$userid\" size=\"30\" maxlength=\"8\" name=\"userid\"> <br><br> 
  Password (Up to 12 characters): <input type=\"text\" value = \"$password\" size=\"30\" maxlength=\"12\" name=\"password\"> <br><br>
  Usertype (0:Student, 1:Administrator, 2: Student-Administrator): <input type=\"text\" value = \"$usertype\" size=\"2\" maxlength=\"1\" name=\"usertype\"> <br><br>
  <input type=\"submit\" value=\"Update\">
  <input type=\"reset\" value=\"Reset to Original Value\">
  </form>
  ");
?>
</body>

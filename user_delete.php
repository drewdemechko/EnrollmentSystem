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
<h1>Web-Based User Management System - Delete User Info</h1>
</header>

<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

// Obtain input from admin.php
$q_userid = $_GET["userid"];
$callingtype=$_GET["callingtype"];
$loginid = $_GET["loginid"];

if($callingtype == NULL)
   $callingtype = 1;	  // 1: admin or student , 2 : student-admin

echo("<ul>
  <li><a class = \"a1\" href=\"admin.php?sessionid=$sessionid&userid=$loginid&callingtype=$callingtype\">Go Back</a></li>
  </ul>");


// Retrieve the tuple to be deleted and display it.
$sql = "select userid, password, usertype from myuser where userid like '%$q_userid%'";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){ // error unlikely
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if (!($values = oci_fetch_array ($cursor))) {
  // Record already deleted by a separate session.  Go back.
  Header("Location:admin.php?sessionid=$sessionid&callingtype=$callingtype&userid=$loginid");
}
oci_free_statement($cursor);

$userid = $values[0];
$password = $values[1];
$usertype = $values[2];

// Display the tuple to be deleted
echo("
   <br><br>
  <form method=\"post\" action=\"user_delete_action.php?sessionid=$sessionid&callingtype=$callingtype&loginid=$loginid\">
  User ID (Read-only): <input type=\"text\" readonly value = \"$userid\" name=\"userid\"><br><br> 
  Password: <input type=\"text\" readonly value = \"$password\" name=\"password\"><br><br>
  Usertype: <input type=\"text\" readonly value = \"$usertype\" name=\"usertype\"><br><br>
  <input type=\"submit\" value=\"Delete\">
  </form>
  ");

?>

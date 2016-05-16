<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
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
        </div>
    </div>
</nav>

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

echo("
   <br><br>
  <form style='margin-left:20px' method=\"post\" action=\"user_add_action.php?sessionid=$sessionid&loginid=$loginid&callingtype=$callingtype\">
  User ID (Up to 8 characters)   : <input type=\"text\" size=\"30\" maxlength=\"8\" name=\"userid\" autofocus required><br><br>
  Password (Up to 12 characters): <input type=\"text\" value = \"$password\" size=\"30\" maxlength=\"12\" name=\"password\" required><br><br>
  User type (0:Student, 1:Administrator, 2: Student-Administrator): <input type=\"text\" value = \"$usertype\" size=\"2\" maxlength=\"1\" name=\"usertype\" required><br><br>
  <div style='inline-flex'>
  <input class='btn btn-primary' type=\"submit\" value=\"Add\">
  <a style='text-decoration:none' class='btn btn-primary a1' href=\"admin.php?sessionid=$sessionid&userid=$loginid&callingtype=$callingtype\">Go Back</a>
  </div>
  </form>
   ");
?>
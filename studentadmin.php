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

$userid=$_GET["userid"];

$wheretocall = "student";

// Here we can generate the content of the welcome page
echo("<div style='float:right; background-color: rgb(40,95,143); top:0; height: 100%;'>
		<ul style='list-style:none; font-weight: 600; font-family:'Microsoft Sans Serif'; font-size:30px;'>
      <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"logout_action.php?sessionid=$sessionid\">Logout</a></li>
  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"change_password.php?sessionid=$sessionid&loginid=$userid&wheretocall=$wheretocall&callingtype='2'\">Change Password</a></li>
  <li style='margin:20px;'><a style='color:white' class = \"a1\" href=\"admin.php?sessionid=$sessionid&userid=$userid&wheretocall=$wheretocall&callingtype='2'\">Administrator</a></li>
  </ul>
	</div>");

echo("  
<img src=\"student.jpg\" alt=\"Be Creative!\" style=\"width:150px;height:150px; position:absolute; right:50px; bottom: 50px;\"> 
<h2 style='text-align:center; margin-top:60px; margin-left: 60px; width: 60%'>
<i class='glyphicon glyphicon-info-sign'></i>
This page will be developed for students to get some information about courses provided
by departments, so they will be able to add or drop classes in this web page. 
</h2>");


?>
</body>
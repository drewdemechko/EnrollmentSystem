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

<a style='margin-left: 45%; margin-top: 120px' class='btn btn-primary' href="login_action.php" target="_self">Return to Login</a></li> 


<?
include "utility_functions.php";

// Get the user id and password and verify them
$userid = $_POST["userid"];
$_SESSION["loginid"] = $userid;
$password = $_POST["pwd"];
$usertype = $_POST["usertype"];

$backupid = $userid;

if($userid != "")
{

     $sql = "select * from myuser where userid = '$userid' and password = '$password'";

    $result_array = execute_sql_in_oracle ($sql);
    $result = $result_array["flag"];
    $cursor = $result_array["cursor"];

	echo("<h2 style='text-align:center'>");
   if ($result == false){  
       display_oracle_error_message($cursor);
       die("User Query Failed.");
    }

    if($values = oci_fetch_array ($cursor)){
        oci_free_statement($cursor);

       // found the client
       $userid = $values[0];
       $type = $values[2];
   
      if($usertype != $type)
     {
             echo ("<BR><BR><BR><BR>UserID: $backupid"); 
        die("... Usertype is not matched");
     } 

      // create a new session for this client
      $sessionid = md5(uniqid(rand()));

      // store the link between the sessionid and the userid
      // and when the session started in the session table

     $sql = "insert into myusersession " .
               "(sessionid, userid, sessiondate) " .
               "values ('$sessionid', '$userid', sysdate)";

     $result_array = execute_sql_in_oracle ($sql);
     $result = $result_array["flag"];
     $cursor = $result_array["cursor"];

     if ($result == false){
         display_oracle_error_message($cursor);
         die("Failed to create a new session");
     }
     else {
        // insert OK - we have created a new session
      if ($type == 0) // student page    
       { 
          header("Location:student.php?sessionid=$sessionid&userid=$userid");
      }
      else if($type == 1) // Admin page    
      { 
         header("Location:admin.php?sessionid=$sessionid&userid=$userid");
      }
      else
      {
	header("Location:studentadmin.php?sessionid=$sessionid&userid=$userid");
      }
     }
    } 
    else { 
       $userid = $values[0];
       echo ("<BR><BR><BR><BR>UserID: $backupid"); 

       // client username not found
       die ('...Login failed.');
    } 
	echo("</h2>");
}
?>
</BODY>

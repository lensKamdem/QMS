<?php
/*  File name: auth_fns_lib.php
	File description: authentication functions library
	File author: Lens Kamdem
	File update date: 14/12/2015 at 11:38
*/
function auth_check_session()
{
/*  It check if the users has an open session
	 Input: null; return: null; 
*/
if (!auth_check_valid_user())
{
/* if the user has no session */

/* if 'name' and 'code' are set */
  if ((isset($_GET['name'])) and (isset($_GET['code'])))
  {
   /* check and format input data */
     $name = $_GET['name'];
     $code = $_GET['code'];
     $name = trim($name);
     $code = trim($code);
     $name = htmlspecialchars($name);
     $code = htmlspecialchars($code);
     if (!get_magic_quotes_gpc())
     {
       $name = addslashes($name);
	   $code = addslashes($code);
     }
	 /* if user is not registered */
	 if (!auth_login($name, $code))
	 {
	   output_header('Login');
	   output_login_form(true);
		output_scripts();
	   output_footer();
	   exit;
	 }
   }
 }
}
function auth_login($name, $code)
{
/*  Find if the user is registered in the db
	Input: user_name, code 'string'; return: true or false (if registered or not)
*/
  $conn = database_db_connect();
  $query ="select id,name from users
			where users.id = '".$code."' and
				  users.name = '".$name."'";
  $result = $conn->query($query);
  if ($result)
  {
    if ($result->num_rows > 0)
	{
	  /* user exist, so open session */
	  $_SESSION['valid_user'] = $name;
	}
	else
	{ 
	  $query2 = "select id, name from admin_user
				where admin_user.id = '".$code."' and
					admin_user.name = '".$name."'";
	  $result2 = $conn->query($query2);
	  if ($result2)
	  {
	    if ($result2->num_rows > 0)
		{
		  /* user exist in db, so open it session */
		  $_SESSION['valid_user'] = $name;
		}
		else
		{
		  $_SESSION['error_msg'] = "User is not registered in database";
		  return false;
		}
	  }
	  else
	  {
	     /* could not execute the query */
	     $_SESSION['error_msg'] = "Error: Query could not be executed, please try again.";
	     return false;
	  }
	}
  }
  else
  {
    /* could not execute the query */
	$_SESSION['error_msg'] = "Error: Query could not be executed, please try again.";
	return false;
  }
  return true;
}
function auth_check_valid_user()
{
/*  It checks it the users has a valid session
	Input: null; return: true or false ('if it has a session or not)
*/
  if (!isset($_SESSION['valid_user']))
  {
    return false;
  }
  return true;
}
function auth_is_admin()
{
/*  It tells whether the login user is an admin or not
	Input: null; return: true or false 'boolean';
*/
 $conn = database_db_connect();
 $result = $conn->query("select * from admin_user where admin_user.name = '".$_SESSION['valid_user']."'");
 if ($result)
 {
   $num_result = $result->num_rows;
   if ($num_result == 0)
   {
     return false;
   }
 }
 else
 {
	$_SESSION['error_msg'] = "Error: Query could not be executed, please try again.";
   return false;
 }
 return true;
}
function auth_is_lecturer($user_name)
{
/*  It checks if the admin user is a lecturer
	 Input: user name "string"; return: true or false (if lecturer)
*/
	$conn = database_db_connect();
	$query = "select * from test_stats,admin_user
				where test_stats.test_id = test.id and
						test.admin_user_id = admin_user.id and
						admin_user.name = '".$user_name."'";
	$result = $conn->query($query);
	if ($result)
	{
		$num_result = $result->num_rows;
		if ($num_result == 0)
		{
			return false;
		}
	}
	else
	{
		$_SESSION['error_msg'] = "Error: Query could not be executed, please try again.";
		return false;
	}
	return true;
}
?>
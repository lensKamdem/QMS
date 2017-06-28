<?php
/*  File name: database_fns_lib.php
	File description: database functions library
	File author: Lens Kamdem
	File update date: 10/10/2015 at 17:37
*/
function database_db_connect()
{
/* Opens connection to the QMS's database
	Input: null; return: db (database query handler)
*/
  $db = new mysqli('localhost', 'qmslens', 'lens59870', 'qms');
  if (!$db)
  {
    $_SESSION['error_msg'] = "Error: Could not connect to database, please try again.";
	return false;
  }
  return $db; 
}
  
  
?>
	
	
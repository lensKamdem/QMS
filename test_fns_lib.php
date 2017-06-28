<?php
/*  File name: test_fns_lib.php
	File description: test function library
	File author: Lens Kamdem
	File update date: 14/10/2015 at 20:26
*/
function test_get_field()
{
/*  It gets all the school fields from the db 
	Input: null; return: null
*/
   $conn = database_db_connect();
   $query = "select id, name from field
			order by name";
   $result = $conn->query($query);
   if (!$result)
   {
	   $_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
	   return false;
   }
   $num_rows = $result->num_rows;
   if ($num_rows == 0)
   {
       $_SESSION['error_msg'] = "Data not found";
	   return false;
   }
   $result = datavalid_turn_to_array($result);   
   return $result;
}
function test_get_level()
{
/*  It gets the school levels or years from the db
	Input: null; return: list of levels 'array';
*/
  $conn = database_db_connect();
  $query = "select distinct levels from users
			order by levels";
  
    $result = $conn->query($query);
	if (!$result)
	{
	   $_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
	  return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
       $_SESSION['error_msg'] = "Data not found";
	  return false;
	}
	$result = datavalid_turn_to_array($result);
  return $result;
}
function test_get_course($level,$field)
{
/*  It gets all the courses for a field at a level
	Input: level 'int', field id 'string'; return: list of courses 'array'
*/
  $conn = database_db_connect();
  $query = "select id,name from course
			where levels = '".$level."' 
			and field_id = '".$field."'
			order by name";
    $result = $conn->query($query);
    if (!$result)
	{
	   $_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
	  return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
       $_SESSION['error_msg'] = "Data not found";
	  return false;
	}
	$result = datavalid_turn_to_array($result);
  return $result;
}
function test_get_test($course)
{
/*  It gets the tests per course
	Input: course id 'string'; return: list of tests 'array'
*/
  $conn = database_db_connect();
  $query = "select id,name,the_date from test
			where course_id = '".$course."'
			order by the_date";
    $result = $conn->query($query);
	if (!$result)
	{
	   $_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
	  return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
       $_SESSION['error_msg'] = "Data not found";
	  return false;
	}
	$result = datavalid_turn_to_array($result);
  return $result;
}
function test_get_test_question($test)
{
/*  It gets the test questions per test
	Input: test id 'integer'; return: list of test questions 'array'
*/
  $conn = database_db_connect();
  $query = "select id,quest_statement,answers,attach from test_question
			where test_id = '".$test."'
			order by id";
    $result = $conn->query($query);
	if (!$result)
	{
	   $_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
	  return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
       $_SESSION['error_msg'] = "Data not found";
	  return false;
	}
	$result = datavalid_turn_to_array($result);
  return $result;
}
function test_get_user_test_result($user,$test)
{
/*  It gets the test results for a user
	Input: user name 'string', test id 'integer'; return: test result 'array'
*/
  $conn = database_db_connect();
  $query = "select test.name,percentage_pass,grade,the_date from test,user_test_result
			where test_id = test.id
			and test_id = '".$test."'
			and user_id = users.id
			and users.name = '".$user."'
			order by the_date";
    $result = $conn->query($query);
	if (!$result)
	{
	   $_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
	  return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
	  $_SESSION['error_msg'] = "No data found";
	  return false;
	}
	$result = datavalid_turn_to_array($result);
  return $result;
}
function test_get_a_test_info($test_id)
{
/*  It gets the $test_id test information
	Input: test id "integer"; return: test info "array"
*/
  $conn = database_db_connect();
  $query = "select * from test
			where id = '".$test_id."'";
  $result = $conn->query($query);
  if ($result)
  {
    $num_result = $result->num_rows;
	if ($num_result == 0)
	{
	  $_SESSION['error_msg'] = "No data found";
	  return false;
	}
	$result = $result->fetch_array();
  }
  else
  {
    $_SESSION['error_msg'] = "Error: could not execute query. Please try again";
	return false;
  }
  return $result;
}
function test_get_a_course_info($course_id)
{
/*  It gets the $course_id course information
	Input: course id "string"; return: course info "array"
*/
  $conn = database_db_connect();
  $query = "select * from course
		where id = '".$course_id."'";
  $result = $conn->query($query);
  if ($result)
  {
    $num_result = $result->num_rows;
	if ($num_result == 0)
	{
	  $_SESSION['error_msg'] = "No data found";
	  return false;
	}
	$result = $result->fetch_array();
  }
  else
  {
    $_SESSION['error_msg'] = "Error: could not execute query. PLease try again.";
	return false;
  }
  return $result;
}
function test_get_name($field_id)
{
	$conn = database_db_connect();
	$query = "select name from field			
					where id = '".$field_id."'";
	$result = $conn->query($query);
	if (!$result)
	{
		$_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
		return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
		$_SESSION['error_msg'] = "No data found";
		return false;
	}
	$result = $result->fetch_array();
	return $result;
}
function test_save_question($id,$test_id,$statement,$answers,$valid_answer,$file)
{
/*  It saves a given question in the database
	 Input: questions id, statemet, answers, valid_answer, file and test id "string"; return: true or false if executed "boolean"
*/
	$conn = database_db_connect();
	$query = "insert into test_question values
					('".$id."','
					".$test_id."','".$statement."','".$answers."','".$valid_answer."','".$file."')";
	$result = $conn->query($query);
	if (!$result)
	{
		$_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
		return false;
	}
	return true;
}
function test_get_test_id($course_id,$test_name,$test_description,$admin_user)
{
/*  It gets the id of a given test from the course, test name, description and admin user	
	 Input: course id, test name, description and admin user "sring"; return: test id "string"
*/
	$conn = database_db_connect();
	$query = "select id,the_date from test		
				where course_id='".$course_id."' and name='".$test_name."'
				and description='".$test_description."' and admin_users_id='".$admin_user."'
				order by the_date";
	$result = $conn->query($query);
	if (!$result)
	{
		$_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
		return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
		$_SESSION['error_msg'] = "No data found 11";
		return false;
	}
	$result = $result->fetch_array();
	
	return $result;
}
function test_save_user_result($test_id,$user_id,$percentage,$grade,$date)
{
/*	 It saves the users answer $answer in the database
	 Input: answer "string"; return: true or false if executed or not
*/
	$conn = database_db_connect();
	$query = "insert into user_test_result values
				('','".$test_id."','".$user_id."','".$percentage."','".$grade."','".$date."')";
	$result = $conn->query($query);
	if (!$result)
	{
		$_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
		return false;
	}
	return true;
}
function test_get_valid_answer($test_id)
{
/*  It gets the questions valid answers from the db
	 Input: test id "int"; return: array of answers "array"
*/
	$conn = database_db_connect();
	$query = "select valid_answer from test_question
				where test_id = ".$test_id."";
	$result = $conn->query($query);
	if (!$result)
	{
		$_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
		return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
		$_SESSION['error_msg'] = "No data found";
		return false;
	}
	$result = datavalid_turn_to_array($result);
	return $result;
}
function test_percentage($no_questions,$mark)
{
/*  It calculates the percentage for a given mark
	 Input: no of questions, mark "int"; return: percentage "int"
*/
	$percentage = (double) (($mark/$no_questions) * 100);
	return $percentage;
}
function test_get_user_id($name)
{
/*  It gets the user's id from it name
	 Input: name "string"; return: user id "string"
*/
	$conn = database_db_connect();
	$query = "select id from users
				where name = '".$name."'";
	$result = $conn->query($query);
	if(!$result)
	{
		$_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
		return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
		$_SESSION['error_msg'] = "No data found";
		return false;
	}
	$result = datavalid_turn_to_array($result);
	return $result;
}
function test_get_all_user_test_result($user)
{
/*  It gets all most recent user tests result
	 Input: user id "string"; return: array of test result "array"
*/
	$conn = database_db_connect();
	$query = "select * from user_test_result
				where user_id='".$user."'
				order by date";
	$result = $conn->query($query);
	if(!$result)
	{
		$_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
		return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
		$_SESSION['error_msg'] = "No data found";
		return false;
	}
	$result = datavalid_turn_to_array($result);
	return $result;
}	
function test_get_test_top_scores($user_level,$user_field)
{
/*  It gets the tests top scores arrange by date for a given level and field
	 Input: user level, user field "string"; return: array of test info "array"
*/
	$conn = database_db_connect();
	$query = "select test_id,user_id,percentage_pass,grade,the_date from user_test_result,test,course
				where user_test_result.test_id = test_id and	
						test.course_id = course.id
						course.levels = '".$user_level."'
						course.field_id = '".$student_field."'
				having distinct test_id
				order by percentage_pass,the_date DESC";
	$result = $conn->query($query);
	if(!$result)
	{
		$_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
		return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
		$_SESSION['error_msg'] = "No data found";
		return false;
	}
	$result = datavalid_turn_to_array($result);
	return $result;
}
function get_user_info($user_name)
{
/*  It gets all user info either normal or admin
    Input: user name "stirng"; return: user info "array"
*/
	$conn = database_db_connect();
	$query = "select * from users
				where name ='".$user_name."'";
	$result = $conn->query($query);
	if(!$result)
	{
		$_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
		return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
		$query2 = "select * from admin_user
						where name ='".$user_name."'";
		$result2 = $conn->query($query2);
		if(!$result2)
		{
			$_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
			return false;
		}
		$num_result2 = $result2->num_rows;
		if ($num_result2 == 0)
		{
			$_SESSION['error_msg'] = "No data found";
			return false;
		}
		$result = datavalid_turn_to_array($result2);
		return $result;
	}
	$result = datavalid_turn_to_array($result);
	return $result;
}
function test_get_user_name($user_id)
{
/*  It gets the user id from a given id on the database	
	 Input: user id "string"; return: user name "string"
*/
	 $conn = database_db_connect();
	 $query = "select name from users
					where id = '".$user_id."'";
	$result = $conn->query($query);
	if(!$result)
	{
		$_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
		return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
		$query2 = "select name from admin_user
						where id ='".$user_id."'";
		$result2 = $conn->query($query2);
		if(!$result2)
		{
			$_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
			return false;
		}
		$num_result2 = $result2->num_rows;
		if ($num_result2 == 0)
		{
			$_SESSION['error_msg'] = "No data found";
			return false;
		}
		$result = datavalid_turn_to_array($result2);
		return $result;
	}
	$result = datavalid_turn_to_array($result);
	return $result;
}
function test_get_test_stats($admin_user_id)
{
/*  It gets tests statistics where the admin_user is equal to $admin_user_id
	 Input: admin user _d "string"; return: array of test stats "array"
*/
	$conn = database_db_connect();
	$query = "select test_id,no_users,percentage_pass,the_date from test_stats, test	
				where test_stats.test_id = test.id and
						test.admin_user_id = '".$admin_user_id."'
				having distinct test_id
				order by the_date,percentage_pass";
	$result = $conn->query($query);
	if(!$result)
	{
		$_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
		return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
		$_SESSION['error_msg'] = "No data found";
		return false;
	}
	$result = datavalid_turn_to_array($result);
	return $result;
}
function test_get_stats()
{
/*  It gets all the statistic from the db
	 Input: null; return: null
*/
	$conn = database_db_connect();
	$query = "select * from test_stats
				order by the_date";
	$result = $conn->query($query);
	if(!$result)
	{
		$_SESSION['error_msg'] = "Error: could not execute query. Please try again.";
		return false;
	}
	$num_result = $result->num_rows;
	if ($num_result == 0)
	{
		$_SESSION['error_msg'] = "No data found";
		return false;
	}
	$result = datavalid_turn_to_array($result);
	return $result;
}
?>
<?php

function userIsLoggedIn()
{
  if (isset($_POST['action']) and $_POST['action'] == 'login')
  {
    if (!isset($_POST['email']) or $_POST['email'] == '' or
      !isset($_POST['password']) or $_POST['password'] == '')
    {
      $GLOBALS['loginError'] = 'Please fill in both fields';
      return FALSE;
    }

    $password = /*md5*/($_POST['password']);
	
    if (databaseContainsAuthor($_POST['email'], $password))
    {
      session_start();
      $_SESSION['loggedIn'] = TRUE;
      $_SESSION['email'] = $_POST['email'];
      $_SESSION['password'] = $password;
      return TRUE;
    }
    else
    {
      session_start();
      unset($_SESSION['loggedIn']);
      unset($_SESSION['email']);
      unset($_SESSION['password']);
      $GLOBALS['loginError'] =
          'The specified email address or password was incorrect.';
      return FALSE;
    }
  }

  if (isset($_POST['action']) and $_POST['action'] == 'logout')
  {
    session_start();
    unset($_SESSION['loggedIn']);
    unset($_SESSION['email']);
    unset($_SESSION['password']);
    header('Location: ' . $_POST['goto']);
    exit();
  }

  session_start();
  if (isset($_SESSION['loggedIn']))
  {
    return databaseContainsAuthor($_SESSION['email'], 
      $_SESSION['password']);
  }
}

function databaseContainsAuthor($email, $password)
{
  include '/works/dental/includes/dentaldb.inc.php';

 //$password = md5($_POST['password'] . 'ijdb');

  try
  {
    $sql = 'SELECT COUNT(*) FROM staff
        WHERE email = :email AND password = :password';
    $s = $pdo->prepare($sql);
    $s->bindValue(':email', $email);
    $s->bindValue(':password', $password);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error searching for author.';
    include 'error.html.php';
    exit();
  }

  $row = $s->fetch();

  if ($row[0] > 0)
  {
    return TRUE;
  }
  else
  {
    return FALSE;
  }
}

function userHasRole($roles)
{
  include '/works/dental/includes/dentaldb.inc.php';

  try
  {
    $sql = "SELECT COUNT(*) FROM staff
        INNER JOIN staffrole ON staff.id = staffid
        INNER JOIN roles ON roleid = roles.id
        WHERE email = :email AND roles.id = :roleId";
    $s = $pdo->prepare($sql);
    $s->bindValue(':email', $_SESSION['email']);
    $s->bindValue(':roleId', $roles);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error searching for author roles.';
    include 'error.html.php';
    exit();
  }

  $row = $s->fetch();

  if ($row[0] > 0)
  {
    return TRUE;
  }
  else
  {
    return FALSE;
  }
}
/**
function userIsLoggedIn()
{
	if (isset($_POST['action']) and $_POST['action'] == 'login')
	{
		if (!isset($_POST['email']) or $_POST['email'] == '' or 
			!isset($_POST['password']) or $_POST['password'] == '')
		{
			$GLOBALS['loginError'] = 'Please fill in both fields';
			return FALSE;
		}

		$password = md5($_POST['password'] . 'idjb');

		if (databaseContainsAuthor($_POST['email'], $password))
		{
			session_start();
			$_SESSION['loggedIn'] = TRUE;
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['password'] = $password;
			return TRUE;
		}
		else
		{
			session_start();
			unset($_SESSION['loggedIn']);
			unset($_SESSION['email']);
			unset($_SESSION['password']);

			echo $_POST['email'];
			echo md5($_POST['password'] . 'idjb');

			$GLOBALS['loginError'] = 
				'The specified email address or password was incorrect.';
			return FALSE;
		}
	}

	if (isset($_POST['action']) and $_POST['action'] == 'logout')
	{
		session_start();
		unset($_SESSION['loggedIn']);
		unset($_SESSION['email']);
		unset($_SESSION['password']);
		header('Location: ' . $_POST['goto']);
		exit();
	}

	session_start();
	if (isset($_SESSION['loggedIn']))
	{
		return databaseContainsAuthor($_SESSION['email'], 
			$_SESSION['password']);
 	}
}


function databaseContainsAuthor($email, $password)
{

	include 'db.inc.php';

	try
	{
		$sql = 'SELECT COUNT(*) FROM authors 
			WHERE email = :email AND password = :password';
		$s = $pdo->prepare($sql);
		$s->bindValue(':email', $email);
		$s->bindValue(':password', $password);
		$s->execute();
	}
	catch (PDOException $e)
	{

		$error = 'Error searching for author.';
		include 'error.html.php';
		exit();
	}

	$row = $s->fetch();

	if ($row[0] > 0)
	{
		return TRUE;

	}
	else
	{
		return FALSE;
	}
	
}

	function userHasRole($role)
	{
		include 'db.inc.php';

		try
		{
			$sql = "SELECT COUNT(*) FROM authors 
			INNER JOIN authorrole ON author.id = authorid 
			INNER JOIN role ON roleid = role.id 
			WHERE email = :email AND role.id = :roleId";
			$s = $pdo->prepare($sql);
			$s->bindValue(':email', $_SESSION['email']);
			$s->bindValue(':roleId', $role);
			$s->execute();
		}
		catch (PDOException $e)
		{
			$error = 'Error searching for author roles.';
			include 'error.html.php';
			exit();
		}

		$row = $s->fetch();

		if ($row[0] > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	**/
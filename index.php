<?php
include  $_SERVER['DOCUMENT_ROOT'] . '/works/chatSystem/includes/access.inc.php';
include  $_SERVER['DOCUMENT_ROOT'] . '/works/chatSystem/includes/db.inc.php';

session_start();
			
			if(isset($_POST['name'])){
				//echo $_POST['name']. "Username found in form";
				//echo $chats['chatname'];
				$_SESSION['name'] = $_POST['name'];
				//echo $_SESSION['name']. "stored in session";
			}else{
				echo "No, form submitted. Old stored information was" . $_SESSION["name"];
			}
			
			
			//$_SESSION['name'] = $_POST['name'];
			//$_SESSION['data_another'] = $_POST['name_another'];



//if statement for vars passed on submit from chatSystem.html.php
if(isset($_POST['submit']))
{
	//if name and message fields empty post $nameErr, else insert name and message into db
	if($_POST['name'] == "" || $_POST['message'] == ""){
	
		$nameErr = '<font color="red">*enter name and message*</font>';
		
	}else{
		
		try
		{
					
			$sql = 'INSERT INTO chat SET 
				chatname = :chatname,
				chatmessage = :chatmessage';
			$s = $pdo->prepare($sql);			
			$s->bindValue(':chatname', $_POST['name']);
			$s->bindValue(':chatmessage', $_POST['message']);
			$s->execute();
			
		}
		catch (PDOException $e)
		{
			$error = 'Error adding submitting chat message ' . $e->getMessage();
			include 'error.html.php';
			exit();
		}
		header('Location: .');
		exit();
	}	
		
}

//include 'chatSystem.html.php';

; ?>

﻿<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="UTF-8">
	<title>chatSystem</title>
	<link rel="stylesheet" href="style.css" media="all"/>
	
	<script>
	//AJAX function defined to help us load messages at runtime, update without refresh
	function loadDoc() {
	
	  var xhttp = new XMLHttpRequest();
	  
	  xhttp.onreadystatechange = function() {
	  
	    if (this.readyState == 4 && this.status == 200) {
	    
	      document.getElementById("chat").innerHTML =
	      this.responseText;
	    }
	  }
	  
	 
	  xhttp.open("GET", "chatSystem2.php", true);
	  xhttp.send();
	}
	
	//set interval function calls the ajax funtion every 1000 milliseconds = 1 second
	setInterval(function() {loadDoc()}, 1000);
		
	</script>
	
</head>

<body onload="loadDoc();">
	
<div id="container">
	<div id="chat_box">
	<!--the chat div below is used with javascript/ajax implementation-->	
	<div id="chat"></div>
		

		
	</div>
	<form method="post" action="index.php">
	<input type="text" name="name" value="<?php echo $_SESSION["name"];?>" />
	<textarea name="message" placeholder="enter message" autofocus></textarea><?php echo $nameErr; ?>
	<input type="submit" name="submit" value="send">
	</form>
</div>

</body>
</html>



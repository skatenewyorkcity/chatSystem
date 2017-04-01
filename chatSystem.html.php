<!DOCTYPE html>
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
  
 
  xhttp.open("GET", "index.php", true);
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
		<?php foreach ($chatss as $chats): ?>
		<div id="chat_data">
			<span style="color:green;"><?php echo htmlspecialchars($chats['chatname'], ENT_QUOTES, 'UTF-8'); ?>: </span>
			<span style="color:brown;"><?php echo htmlspecialchars($chats['chatmessage'], ENT_QUOTES, 'UTF-8'); ?></span>
			<span style="float:right;"><?php echo formatDate(htmlspecialchars($chats['chatdate'], ENT_QUOTES, 'UTF-8')); ?></span>
		</div>
		<?php endforeach; ?>
		
	</div>
	<form method="post" action="index.php">
	<input type="text" name="name" placeholder="enter name"/>
	<textarea name="message" placeholder="enter message"></textarea><?php echo $nameErr; ?>
	<input type="submit" name="submit" value="send">
	
	</form>
</div>

</body>
</html>
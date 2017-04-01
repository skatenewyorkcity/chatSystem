<?php

include  $_SERVER['DOCUMENT_ROOT'] . '/works/chatSystem/includes/db.inc.php';

//pull information from the database
try
{
	$sql = 'SELECT chatid, chatname, chatmessage, chatdate FROM chat ORDER BY chatid DESC LIMIT 11';
	$result = $pdo->query($sql);
}
catch (PDOException $e)
{
	$error = 'Error fetching content: ' . $e->getMessage();
	include '/works/chatSystem/includes/output.html.php';
	exit();
}
		
foreach ($result as $row)
{
	$chatss[] = array(
			'chatid' => $row['chatid'],
			'chatname' => $row['chatname'],
			'chatmessage' => $row['chatmessage'],
			'chatdate' => $row['chatdate']
			);			
}

//function to format date to output just the time, implemeneted in chatSystem.html.php
function formatDate($date){
	return date('g:i a', strtotime($date));
}

; ?>

<?php foreach ($chatss as $chats): ?>
		<div id="chat_data">
			<span style="color:green;"><?php echo htmlspecialchars($chats['chatname'], ENT_QUOTES, 'UTF-8'); ?>: </span>
			<span style="color:brown;"><?php echo htmlspecialchars($chats['chatmessage'], ENT_QUOTES, 'UTF-8'); ?></span>
			<span style="float:right;"><?php echo formatDate(htmlspecialchars($chats['chatdate'], ENT_QUOTES, 'UTF-8')); ?></span>
		</div>
<?php endforeach; ?>	
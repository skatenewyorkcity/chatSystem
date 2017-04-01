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



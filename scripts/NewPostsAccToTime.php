<?php
session_start();
//require_once('../scripts/connection.php');

require_once('../scripts/NewPosts.php');
?>

<!DOCTYPE HTML>
<html>

<head>
  <title> Social News Platform</title>
</head>

<link type="text/css" rel="stylesheet" href="../stylesheets/main.css">

<div id="header">
<h1> Social News Platform </h1>
</div>

<body>
    <!-- navigation bar -->
    <div class = "navbar">
    <!-- ordered list within unordered list -->
      <ul class = "navigation">
          <li> <a href= "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/HomePage.php"> What's Hot!! </a> </li>
          <li> <a href=  "#NewPost"> What's New! </a> </li>
          <li> <a href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/Profile.php"> Profile </a> </li>
          <li> <a href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Post.php" > Create a new post </a> </li>
          <li> <a id= 'logout' href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/login.html"> Log out  </a> </li> 
    
      </ul>
    </div>


<div class = "NewPosts">
<h1><font color= 'red'> What's New - 20 Recent Posts! </font></h1>
<?php
	
    foreach($newPosts as $newPost){
      echo "<ul class =". "NewPostsList>";  
         echo "<li id =". "postvotes>". $newPost['PVOTES']."</li>";
       // echo "<li id ="."post_title>". $newPost['POST_TITLE']. "<button id = " . "button class=". "pure-button pure-button-active".">Vote</button></li>";
        
         if ( $_SESSION['myusername'] == $newPost['POST_USERNAME']){ 
           echo "<li id ="."post_title>". $newPost['POST_TITLE']. "<button id = " . "button class=". "pure-button pure-button-active".">Vote</button>
           <button id = " . "button class=". "pure-button pure-button-active".">Edit</button> 
           <button id = " . "button class=". "pure-button pure-button-active".">Delete</button></li>";
        
        }
        else
            echo "<li id ="."post_title>". $newPost['POST_TITLE']. "<button id = " . "button class=". "pure-button pure-button-active".">Vote</button></li>";
        
        
        
    
         echo "<li id =". "post_content>".$newPost['POST_CONTENT']. "</li>";
         echo "<li id =". "post_username>". $newPost['POST_USERNAME']. "</li>";
         echo "<li id =". "post_time>". $newPost['POST_TIME']. "</li>";
       echo "</ul>";  

      }
       
?>
</div>
</body>
</html>

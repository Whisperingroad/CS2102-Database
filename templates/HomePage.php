<?php
session_start();
//require_once('../scripts/connection.php');

require_once('../scripts/HotPosts.php');
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
          <li> <a href= "#HotPost"> Hot Posts </a> </li>
          <li> <a href= "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/NewPostsAccToTime.php"> New Posts </a> </li>
          <li> <a href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/Profile.php"> Profile </a> </li>
          <li> <a href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/Post.php" > Create a new post! </a> </li>
          <li> <a id= 'logout' href = "http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/login.html"> Log out  </a> </li> 
    
      </ul>
    </div>


<div class = "HotPosts">
<?php
       // assessing one result row at a time 
    foreach($hotPosts as $hotPost){
      // displaying results from the hotPost array
      echo "<ul class =". "HotPostsList>";  
         echo "<li id =". "postvotes>". $hotPost['PVOTES']."</li>";
        // echo "<li id ="."post_title>". $hotPost['POST_TITLE']. "<button id = " . "button class=". "pure-button pure-button-active".">Vote</button></li>";
        
        
        //echo $_SESSION['myusername'];
        //echo $hotPost['POST_USERNAME'];
        
       if ( $_SESSION['myusername'] == $hotPost['POST_USERNAME']){ 
           echo "<li id ="."post_title>". $hotPost['POST_TITLE']. "<button id = " . "button class=". "pure-button pure-button-active".">Vote</button>
           <button id = " . "button class=". "pure-button pure-button-active".">Edit</button> 
           <button id = " . "button class=". "pure-button pure-button-active".">Delete</button></li>";
        
        }
        else
             echo "<li id ="."post_title>". $hotPost['POST_TITLE']. "<button id = " . "button class=". "pure-button pure-button-active".">Vote</button></li>";
           
            
        
        
        
         echo "<li id =". "post_content>".$hotPost['POST_CONTENT']. "</li>";
         echo "<li id =". "post_username>". $hotPost['POST_USERNAME']. "</li>";
         echo "<li id =". "post_time>". $hotPost['POST_TIME']. "</li>";
       echo "</ul>";  

      }
       
?>
</div>
</body>
</html>

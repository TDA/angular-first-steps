#!/usr/bin/php-cgi
<?php
session_start();

if (!isset($_SESSION['username'])) {
   if (!isset($_POST['username']) || !isset($_POST['password'])) {
     echo "<p>Missing parameters</p>";
     exit(0);
   }
   $_SESSION['username'] = $_POST['username'];
   $_SESSION['password'] = $_POST['password'];
   echo "<p>Welcome " . $_SESSION['username'] . "</p>";
   $nonce = rand();
   $_SESSION['nonce'] = $nonce;
?>
   <form action="/~level04/cgi-bin/it.php" method="post">
   <p>File: <input type="text" name="filename" /></p>
   <p>Data: <input type="text" name="data" /></p>
   <p><input type="submit" value="Submit"></p>
<?php
   echo "<p><input type=\"hidden\" name=\"nonce\" value=\"" . $nonce . "\" /></p>";
   echo "</form>";
   exit(0);
}
   if (isset($_POST['nonce']) && !isset($_POST['readmode'])) {
      if ($_POST['nonce'] != $_SESSION['nonce']) {
      	 echo "<p>Wrong nonce</p>";
	 exit(0);
       }
       $f = fopen($_POST['filename'], "a+");
       fwrite($f, $_POST['data']);
       fclose($f);
?>
<form action="/~level04/cgi-bin/it.php" method="post">
   <p><input type="text" name="filename" /></p>
   <p><input type="hidden" name="readmode" value="yes"/></p>
   <p><input type="submit" value="Read" /></p>

<?php
   echo "<p><input type=\"hidden\" name=\"nonce\" value=\"" . $_SESSION['nonce'] . "\" /></p\
>";
        echo "</form>";
	exit(0);
    }
    if (isset($_POST['nonce']) && isset($_POST['readmode'])) {
      if ($_POST['nonce'] != $_SESSION['nonce']) {
         echo "<p>Wrong nonce</p>";
         exit(0);
       }
       $filename = getcwd() . "/" . $_POST['filename'];
       $lines = implode('', file($_POST['filename']));
       echo $lines;
       exit(0);
    }
    echo "<p>What?</p>"
?>


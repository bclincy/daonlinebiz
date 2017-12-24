<? if(!isset($_SESSION['user'])){ ?>
<form action="login.php" method="post" id="frmlogin">
<div id="pagelogin">
  <label for="username">Email:</label>
  <input type="text" name="username" id="username">
  <label for="password">Password:</label>
  <input type="text" name="password" id="password">
  <input type="submit" name="btnlogin" id="btnlogin" value="Sign-in">
</div></form>
<?
}
else{ echo "<div id=\"pagelogin\">{$_SESSION['user']} <span><a href=\"login.php?signout=true\">Sign Out</a></span></div>";}
?>
<div id="container">
  <header> 
    <!-- logo --> 
    <a href="./" id="logo"><img src="images/dalogo.gif" width="249" height="94" alt="Da Online Biz (The Online Biz) "></a> 
    <!-- /logo --> 
    <!-- nav -->
    <nav>
      <ul>
        <li><a href="./" class="current">Home</a></li>
        <li><a href="aboutus.php">About us</a></li>
        <li><a href="products.php">Services</a></li>
        <li><a href="news.php">News</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
    <!-- /nav --> 
  </header>
  <!-- Content --> 
  <div class="content">

<? include_once('inc/functions.php'); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Muskegon Heights School Academy: Contact Us</title>
<link href="css/default.css" rel="stylesheet" type="text/css">
</head>

<body>
<? include_once('header.php'); ?>
<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="contact" id="contact">
  <h3> <a name="form" id="form"></a>Contact Form</h3>
  <div class="breadcrum"><ul><li><a href="#form">Contact Form</a></li>
<li><a href="#postal">Postal Address</a></li><li><a href="#phone" class="last">Telephone Number</a>
</ul></div>
  <div class="leftcol">
  <h3><a name="postal" id="postal"></a>Postal address:  </h3>
  <blockquote>
  <p><a href="https://maps.google.com/?q=2441+Sanford+St,+Muskegon+Heights,+MI+49444">Muskegon Heights Schools Academy</a><br />
   2441 Sanford St<br />
   Muskegon Heights, Michigan 49444</p>
  </blockquote>
  <h2><a name="phone" id="phone"></a>Telephone</h2>
  <blockquote>  
    <p>Phone: 231.830.3703</p>
  </blockquote>
  </p>
  </div>
<div class="leftcol">
<? if(isset($msg['message'])){ echo "<h3>{$msg['message']}</h3>"; } ?>
  <p>
    <label for="name">Name:</label>
    <input name="name" type="text" id="name" value="<?= reposted('name'); ?>" size="25" maxlength="70" /><span style="color:#F00; font-weight:bold;">*</span> 
    <? if(isset($msg['name'])){ echo "<div class=\"error\">* {$msg['name']}</div>"; } ?>  </p>
  <p>
    <label for="emailadd">Email Address:</label>
    <input name="emailadd" type="text" id="emailadd" value="<?= reposted('emailadd'); ?>" size="25" maxlength="50" /><span style="color:#F00; font-weight:bold;">*</span>
    <? if(isset($msg['emailadd']) || isset($msg['invalidemail'])){ echo "<div class=\"error\">* {$msg['emailadd']} {$msg['invalidemail']} </div>"; }?></p>
  <p>
    <label for="label">Phone Number</label>
    <input name="phone" type="text" id="label" value="<?= phone_number(reposted('phone')); ?>" size="25" maxlength="12" /> 
    </p>
  <p>
    <label for="subject">Subject:</label>
    <input name="subject" type="text" id="subject" value="<?= reposted('subject'); ?>" size="25" maxlength="200" />
  </p>
   <p><label for="message">Message:
  <span style="vertical-align:top;" class="error">* <?=$msg['message']; ?></span></label>
    <textarea name="message" cols="40" rows="10" id="message"><?= stripslashes(reposted('message')); ?></textarea><span style="vertical-align:top; vertical-align:top; color:#F00;">*</span>
  </p>
  <p><span class="error">* are required field.</span></p>
  <p>
    <label for="send">&nbsp;</label><input type="submit" name="Send" id="Send" value="Send Message" />
  </p>
  </div>

</form>
<? include('footer.php'); ?>
</body>
</html>
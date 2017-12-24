<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Computer</title>
<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="" method="post" name="frmProblem" id="frmProblem">
  <p>
    <label for="compmod">Computer Make:</label>
    <select name="compmod" id="compmod">
      <option value="Acer">Acer</option>
      <option value="Alienware">Alienware</option>
      <option value="ASUS">ASUS</option>
      <option value="Compaq">Compaq</option>
      <option value="Dell">Dell</option>
      <option value="eMachine">eMachine</option>
      <option value="Gateway">Gateway</option>
      <option value="HP">Hewlett-Packard</option>
      <option value="Mac">Mac</option>
      <option value="IBM">IBM</option>
      <option value="Hitachi">Hitachi</option>
      <option value="LG">LG</option>
      <option value="Medion">Medion</option>
      <option value="Micro-Center">Micro Center</option>
      <option value="Panisonic">Panisonic</option>
      <option value="Samsung">Samsung</option>
      <option value="Sony">Sony</option>
      <option value="Systemax">Systemax</option>
      <option value="Toshiba">Toshiba</option>
      <option value="Other">Other</option>
    </select>
  </p>
  <p>
    <label for="compAge">Aprox Computer Age:</label>
    <select name="compAge" id="compAge">
      <option value="6">6 Mos</option>
      <option value="12">1 year</option>
      <option value="18">18 Mos</option>
      <option value="24">2 Years</option>
      <option value="36">3 Year</option>
      <option value="48">4 Years</option>
      <option value="60">5 years +</option>
    </select>
  </p>
  <p>
    <label for="compType">Computer Type:</label>
    <select name="compType" id="compType">
      <option value="Desktop">Desktop</option>
      <option value="Laptop">Notebook/Laptop</option>
      <option value="Thin">Thin Client</option>
      <option value="Server">Server</option>
      <option value="Work">Work Station</option>
    </select>
  </p>
  <p>
    <input type="radio" name="radio" id="myoptions" value="myoptions">
    <label for="myoptions">Computer Problems</label> 
    <input type="radio" name="radio" id="task" value="task">
    <label for="task">Help with A Tasks</label>
    <input type="radio" name="radio" id="displayall" value="displayall">
    <label for="displayall">Display All</label>
  </p>
  <fieldset id="problem">
    <legend>Computer Problem?</legend>
    <p>
      <input type="checkbox" name="problem[]" id="turnon" class="problem">
      <label for="turnon">Won't Turn On</label>
    </p>
    <p>
      <input type="checkbox" name="problem[]" id="sluggish" class="problem">
      <label for="sluggish">Sluggish/Slow</label>
    </p>
    <p>
      <input type="checkbox" name="problem[]" id="errormsg">
      <label for="errormsg">Error Messages</label>
    </p>
    <p>
      <input type="checkbox" name="problem[]" id="lockup">
      <label for="lockup">Freeze/Lock Up</label>
    </p>
    <p>
      <input type="checkbox" name="problem[]" id="Network">
      <label for="Network">No Network Connection</label>
    </p>
    <p>
      <input type="checkbox" name="problem" id="reboot">
      <label for="reboot">Spontaneously Reboot</label>
    </p>
    <p>
      <input type="checkbox" name="program" id="program">
    <label for="program">Program Not Working</label></p>
    <p>
      <input type="checkbox" name="problem[]" id="hijacked">
      <label for="hijacked">Hi-jacked/Switch Search, Home page, Tool Bars, Pop Ups and Malware</label>     
    </p>
    <p>
      <input type="checkbox" name="problem[]" id="hardware2">
      <label for="hardware2">Devices Not working i.e. CD ROM, USB Port, No Sound and External Drives</label>
    </p>
    <p>
      <input type="checkbox" name="problem[]" id="virus">
      <label for="virus">Viruses/Spyware</label>
    </p>
    <p>
      <input type="checkbox" name="noise" id="noise">
      <label for="noise">Unusual noises &amp; vibrations</label>
    </p>
    <p>
      <input type="checkbox" name="heat" id="heat">
      <label for="heat">Overheating</label>
    </p>
  </fieldset>
  <fieldset id="help">
    <legend>Computer Help</legend>
    <p>
      <input type="checkbox" name="email" id="email">
      <label for="email">Computer Setup: Plug-in, Program Installation, Optimization</label></p>
    <p>
      <input type="checkbox" name="music" id="music">
      <label for="music">Music Management (Ipod &amp; MP3 player syncing)</label>
    </p>
    <p>
      <input type="checkbox" name="wifi" id="wifi">
      <label for="wifi">Installing Wireless Network</label>
    </p>
    <p>
      <input type="checkbox" name="printsetup" id="printsetup">
      <label for="printsetup">Install/Setup Printer</label>
    </p>
    <p>
      <input type="checkbox" name="voip" id="voip">
      <label for="voip">Setup Voice Over IP</label>  
    </p>
    <p>
      <input type="checkbox" name="backup" id="backup">
      <label for="backup">System Back Up/Restore</label>
    </p>
    <p>
      <input type="checkbox" name="install" id="install">
      <label for="install">Install Software</label>
    </p>
  </fieldset>
  <fieldset id="somethingelse">
  <label>Not Listed</label>
  </fieldset>
</form>

</body>
</html>
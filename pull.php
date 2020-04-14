<?
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
// first command
$result = shell_exec("git version");
echo"<pre>";  print_r($result); echo"</pre><hr/>";
// secand command
$command = "git pull origin master";
$result = shell_exec($command);
echo"<h2>$command</h2><pre>";  print_r($result); echo"</pre><hr/>";

<?php

$plugins_dir 	= dirname(dirname(dirname(dirname(__FILE__).'..'.DIRECTORY_SEPARATOR)));
$plugins = scandir($plugins_dir);
$git = array();

foreach($plugins as $plugin_dir) {

    $plugin_dir = $plugins_dir.'/'.$plugin_dir;
    if(!is_dir($plugin_dir) || in_array($plugin_dir, array('.','..'))) continue;

    $git_dir = $plugin_dir.'/'.'.git';

    if(file_exists($git_dir)) {

        $stringfromfile = file($git_dir.'/HEAD', FILE_USE_INCLUDE_PATH);

        $gs=explode('/', $stringfromfile[0]);
        $gs = end($gs);

        @$git[$gs]++;

    }

    arsort($git);
}
?>

<div style="border-radius:10px;padding:10px;margin-bottom:15px;opacity:0.75;border:solid 1px #ff6666;background: #ffaaaa;">
    <center>
        <h3>Git Branch</h3>
        <?php foreach($git as $v=>$c) { echo "$v <small style='font-size:0.8em;opacity:0.5'>($c)</small><br/>"; } ?>
    </center>
</div>
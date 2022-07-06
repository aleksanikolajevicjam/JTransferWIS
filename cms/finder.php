<?php 
session_start();
?>

<html>
<style>
	.badge {
		margin: 0 6px;
		width: 3em;
	}
	.php {
		background: purple;
	}
	.js {
		background: orange;
	}
	.css {
		background: blue;
	}
	.ini {
		background: green;
	}
</style>
<body>
<div align="center">
	<h1>Finder</h1>
	<br>
	<form action="" method="post">
		Find:
		<input type="text" name="string" style="width:40em">
		<button type="submit"> Go </button>
	</form>
</div>

<?
if($_SESSION['UserAuthorized']!=1) die('You have to Login dude :P');

$find = $_REQUEST['string'];

echo findString (ROOT, $find);

function findString ($path, $find) {
    $return='';
	$results = 0;
    ob_start();
    if ($handle = opendir($path)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                if(is_dir($path.'/'.$file)){
                    $sub=findString($path.'/'.$file,$find);
                    if(isset($sub)){
                        echo $sub.PHP_EOL;
                    }
                } else {
                    $ext=substr(strtolower($file),-3);
                    if ($ext == 'php' or $ext == '.js' or $ext == 'css' or $ext == 'ini') {
                        $filesource=file_get_contents($path.'/'.$file);
                        $pos = strpos($filesource, $find);
                        if ($pos === false) {
                            continue;
                        } else {				
							if ($ext == 'php') {
								$icon = '<span class="badge php">php</span>';
							}
							if ($ext == '.js') {
								$icon = '<span class="badge js">js</span>';
							}
							if ($ext == 'css') {
								$icon = '<span class="badge css">css</span>';
							}
							if ($ext == 'ini') {
								$icon = '<span class="badge ini">ini</span>';
							}
							$results++;
							echo $icon . "The string '$find' was found in the file '$path/$file and exists at position $pos<br />";
                        }
                    } else {
                        continue;
                    }
                }
            }
        }
        closedir($handle);
    }
//	echo '<br>' . $results . ' results found<br><br>';

    $return = ob_get_contents();
    ob_end_clean();
    return $return;
}
?>
</body>
</html>

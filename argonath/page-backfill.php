<?php 
/* 
Template Name: Backfill Tweets
*/

header('Content-Type: text/html charset='.get_option('blog_charset'), true);
echo "<html>";
echo "\n";
echo "<body>";

if(isset($_REQUEST["tweet_load"])) {

	$dir_path = "http://www.allyngibson.net/tweets/";

	$haveCount = 0;
	$addCount = 0;

	if (is_dir($dir_path)) {
	    if ($dir_handler = opendir($dir_path)) {
	        while (($file = readdir($dir_handler)) !== false) {
	        	if(strpos($file, ".js") > 0){

	        		echo "loading " . $dir_path . $file . "<br>";

					$contents = file_get_contents($dir_path . $file);
					$contents = substr($contents, strpos($contents, "["));
					$contents = "{ \"json\" : $contents }";
					$json = json_decode($contents);

					foreach($json->json as $twt){
						$t = new AKTT_Tweet($twt);
						if (!$t->exists_by_guid()) {
							$t->add();
							echo "adding " . $t->id() . "<br>";
							$addCount++;
						}else{
							echo "passing " . $t->id() . "<br>";
							$haveCount ++;
						}
					}
	        	}
	        }
	        closedir($dir_handler);
	    }
	}

	echo "adding: $addCount<br />";
	echo "\n";
	echo "have: $haveCount<br />";
	echo "\n";

}

echo "</body>";
echo "\n";
echo "</html>";

?>
<?php
class TwitterHelper extends Helper
{

//	var $feed_name = "asecondwill";
//	var	$cache_rss = dirname(__FILE__).'/tmp/cache/views/twitter_cache.rss';
	var $helpers = array('Time');
	
function tweet($usernames, $limit) {
	$result  = '';
	$username_for_feed = str_replace(" ", "+OR+from%3A", $usernames);
	$feed = "http://search.twitter.com/search.atom?q=from%3A" . $username_for_feed . "&rpp=" . $limit;
	$usernames_for_file = str_replace(" ", "-", $usernames);
	
	$cache_file = ROOT . '/app/tmp/cache/twitter/' . $usernames_for_file . '_' . $limit . '-twitter-cache';
	
	$last ="";
	if (is_file($cache_file))$last = filemtime($cache_file);;
	
	$now = time();
	$interval = 600; // ten minutes
	// check the cache file
	if ( !$last || (( $now - $last ) > $interval) ) {
		// cache file doesn't exist, or is old, so refresh it
		$cache_rss = file_get_contents($feed);
		if (!$cache_rss) {
			// we didn't get anything back from twitter
			echo "<!-- ERROR: Twitter feed was blank! Using cache file. -->";
		} else {
			// we got good results from twitter
			echo "<!-- SUCCESS: Twitter feed used to update cache file -->";
			$cache_static = fopen($cache_file, 'wb');
			fwrite($cache_static, serialize($cache_rss));
			fclose($cache_static);
		}
		// read from the cache file
		$rss = @unserialize(file_get_contents($cache_file));
	}
	else {
		// cache file is fresh enough, so read from it
		echo "<!-- SUCCESS: Cache file was recent enough to read from -->";
		$rss = @unserialize(file_get_contents($cache_file));
	}
	// clean up and output the twitter feed
	$feed = str_replace("&amp;", "&", $rss);
	$feed = str_replace("&lt;", "<", $feed);
	$feed = str_replace("&gt;", ">", $feed);
	$clean = explode("<entry>", $feed);
	$clean = str_replace("&quot;", "'", $clean);
	$clean = str_replace("&apos;", "'", $clean);
	$amount = count($clean) - 1;
	$result .="<ul id='tweets'>";
	if ($amount) { // are there any tweets?
		for ($i = 1; $i <= $amount; $i++) {
			$entry_close = explode("</entry>", $clean[$i]);
			$clean_content_1 = explode("<content type=\"html\">", $entry_close[0]);
			$clean_content = explode("</content>", $clean_content_1[1]);
			$clean_name_2 = explode("<name>", $entry_close[0]);
			$clean_name_1 = explode("(", $clean_name_2[1]);
			$clean_name = explode(")</name>", $clean_name_1[1]);
			$clean_user = explode(" (", $clean_name_2[1]);
			$clean_lower_user = strtolower($clean_user[0]);
			$clean_uri_1 = explode("<uri>", $entry_close[0]);
			$clean_uri = explode("</uri>", $clean_uri_1[1]);
			$clean_time_1 = explode("<published>", $entry_close[0]);
			$clean_time = explode("</published>", $clean_time_1[1]);
			$unix_time = strtotime($clean_time[0]);
			$pretty_time = $this->Time->niceShort($unix_time);
			$result .=	"
					<li>
						{$clean_content[0]}
						<time>
							{$pretty_time}
						</time>
					</li>
				";
			
		}
	} else { // if there aren't any tweets
		
		$result .=	"<li>
						No recent tweets! we are probably busy shovelling coal into the empires engine.	
					</li>";
		
	}
	$result .="</ul>";
	return $result;
}

}

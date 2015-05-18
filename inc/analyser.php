<?php
date_default_timezone_set('UTC');
include_once('simple_html_dom.php');

//analyser ('../page.htm', array ("soroush" => 0, "homa" => 1));

function analyser($url, $target_user_names = array())
{
	$ranking_list = file_get_html($url);
	
	$result = array();
	$i = 1;
	$temp_try = array();
	
	foreach($ranking_list->find('tr') as $element)
	{
		// just process odd nodes
		if ($i % 2 == 0)
		{
			// getting username from current element (table row)
			// tr->td->center->a->{{value}}
			$user_name = strtolower(trim($element->children(1)->children(0)->children(0)-> innertext));
			if( (array_key_exists($user_name, $target_user_names) AND $target_user_names[$user_name] === 1) OR empty($target_user_names) )
			{
				// counting tries
				if ( isset ($temp_try[$user_name]) )
				{
					$temp_try[$user_name]++;
				}
				else
				{
					$temp_try[$user_name] = 1;
				}
				
				// replace latest info if multiple info found else set initial info
				if(!isset($result[$user_name]) OR $result[$user_name]['result'] !== TRUE)
				{
					// getting user result from current element (table row) and set TRUE if accepted
					// tr->td->center->span->{value}
					$user_result = $element->children(7)->children(1)->children(0)-> innertext;
					$user_result = strtolower(trim($user_result));
					if (strcmp($user_result, 'accepted') === 0)
					{
						$user_result = TRUE;
					}
					else
					{
						$user_result = FALSE;
					}
						
					// getting user time from current element (table row)
					// tr->td->center->{value}
					$user_submit_time = $element->children(2)->children(0)-> innertext;
					$user_submit_time = strtotime($user_submit_time);
					
					// replace latest user info
					if(isset($result[$user_name]))
					{
						if($result[$user_name]['time'] < $user_submit_time)
						{
							$result[$user_name]['result'] = $user_result;
							$result[$user_name]['time'] = $user_submit_time;
						}
					}
					// set initial user info
					else
					{
						$result[$user_name]['result'] = $user_result;
						$result[$user_name]['time'] = $user_submit_time;
					}
				}
			}
		}
		$i++;
	}
	foreach ($result as $username => $user_result)
	{
		$result[$username]["try"] = $temp_try[$username];
	}
	
	//var_dump ($result);
	return ($result);
}
?>
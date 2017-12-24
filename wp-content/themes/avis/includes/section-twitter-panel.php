<?php
/**
 * @package	 WordPress
 * @subpackage  Avis
 * @version	 1.0.0
 *
 * Theme Twitter Template For Front Page.
 * Created by sketchthemes
*/
?>
<?php global $avis_shortname;
	$_home_twitter_section  = get_post_meta( $post->ID,'_home_twitter_section',true );
	$_home_twitter_heading  = get_post_meta( $post->ID,'_home_twitter_heading',true );
	$_home_twitter_desc	 = get_post_meta( $post->ID,'_home_twitter_desc',true );
?>

<!-- .twitter slider section starts -->
<?php if($_home_twitter_section == 'on'){ ?>
<div id="full-twitter-box" class="avis-section">
	<div class="container">

		<div class="sections_inner_content fade_in_hide element_fade_in">
			<?php if (isset($_home_twitter_heading) && $_home_twitter_heading !='') { ?><h2 class="section_heading"><?php echo $_home_twitter_heading; ?></h2><?php } ?>
			<?php if (isset($_home_twitter_desc) && $_home_twitter_desc !='') { ?><div class="section_description"><?php echo $_home_twitter_desc; ?></div><?php } ?>
			<p class="front-title-seperator"><span></span></p>
		</div>

		<div class="row-fluid">
			<div id="bot-twitter">
			<div class="twitter-row">
				<?php
				$numTweets  	= avis_get_option($avis_shortname."_tws_no_twitts"); // Number of tweets to display.
				$name		 	= avis_get_option($avis_shortname."_tw_username");// Username to display tweets from.
				$excludeReplies = false; // Leave out @replies
				$transName 		= 'list-tweets'; // Name of value in database.
				$cacheTime 		= avis_get_option($avis_shortname."_cachetime"); // Time in minutes between updates.
				$backupName		= $transName . '-backup';
				$retweeted		= true;
				
				$_tws_effect	= avis_get_option($avis_shortname."_tws_effect");
				$_tws_delay	 = avis_get_option($avis_shortname."_tws_delay");
				$_tws_speed	 = avis_get_option($avis_shortname."_tws_speed");
				$_tws_autoplay  = avis_get_option($avis_shortname."_tws_autoplay");
				$_tws_pause	 = avis_get_option($avis_shortname."_tws_pause");
				
				$_tws_autoplay  = ($_tws_autoplay === "on") ? 1 : 0;
				$_tws_pause	 = ($_tws_pause === "on") ? 1 : 0;

				// Do we already have saved tweet data? If not, lets get it.
				/*if(false === ($tweets = get_transient($transName) ) ) :*/

				// Get the tweets from Twitter.
				require_once locate_template('includes/twitteroauth.php');

				$twitter_consumer = avis_get_option($avis_shortname."_twitter_consumer");
				$twitter_con_s 	  = avis_get_option($avis_shortname."_twitter_con_s");
				$twitter_acc_t 	  = avis_get_option($avis_shortname."_twitter_acc_t");
				$twitter_acc_t_s  = avis_get_option($avis_shortname."_twitter_acc_t_s");

				$connection = new TwitterOAuth(
					$twitter_consumer, // Consumer Key
					$twitter_con_s, // Consumer secret
					$twitter_acc_t, // Access token
					$twitter_acc_t_s // Access token secret
				);

				// If excluding replies, we need to fetch more than requested as the
				// total is fetched first, and then replies removed.

				$totalToFetch = ($excludeReplies) ? max(50, $numTweets * 3) : $numTweets;

				$fetchedTweets = $connection->get(
					'statuses/user_timeline',
					array(
						'screen_name' => $name,
						'count' => $totalToFetch,
						'exclude_replies' => $excludeReplies,
						'truncated' =>  false
					)
				);

				
				//print_r($fetchedTweets);
				// Did the fetch fail?
				if ($connection->http_code != 200) :
					$tweets = get_option($backupName); // False if there has never been data saved.
				else :
					// Fetch succeeded.
					// Now update the array to store just what we need.
					// (Done here instead of PHP doing this for every page load)
					$limitToDisplay = min($numTweets, count($fetchedTweets));

					for ($i = 0; $i < $limitToDisplay; $i++) :
						$tweet = $fetchedTweets[$i];
						
						// Core info.
						$name = $tweet->user->name;
						$retweeted = $tweet->retweeted;
						$permalink = 'http://twitter.com/' . $name . '/status/' . $tweet->id_str;


						/* Alternative image sizes method: http://dev.twitter.com/doc/get/users/profile_image/:screen_name */
						$image = $tweet->user->profile_image_url;

						// Message. Convert links to real links.
						$pattern = '/http:(\S)+/';
						$replace = '<a href="${0}" target="_blank" rel="nofollow">${0}</a>';
						$text = preg_replace($pattern, $replace, $tweet->text);

						// Need to get time in Unix format.
						$time = $tweet->created_at;
						$time = date_parse($time);
						$uTime = mktime($time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year']);
						
						$t1 = "<a href='http://twitter.com/intent/tweet?in_reply_to=$tweet->id_str;' class='tweet_action tweet_reply' target='_blank'>reply</a>";
						$t2 = "<a href='http://twitter.com/intent/retweet?tweet_id=$tweet->id_str;' class='tweet_action tweet_retweet' target='_blank'>retweet</a>";
						$t3 = "<a href='http://twitter.com/intent/favorite?tweet_id=$tweet->id_str;' class='tweet_action tweet_favorite' target='_blank'>favorite</a>";
						
						//echo $retweeted.'sas';
						// Now make the new array.
						$tweets[] = array(
							'text' => $text,
							'name' => $name,
							'permalink' => $permalink,
							'image' => $image,
							'time' => $uTime,
							'reply_action'	  => $t1,
							'retweet_action'  => $t2,
							'favorite_action'  => $t3
				
						);
					endfor;
					update_option($backupName, $tweets);
				endif;
				?>
				
				<div class="tw-slider clearfix">
					<ul class="twitter_box slides">
						<?php if($tweets) { ?>
						<?php foreach ($tweets as $t) : ?>
							<li class="twitter-item">								
								<?php echo '<span class="tw-text">'.$t['text'].'</span>'; ?>
								 <div class="date_outer"><span class="tw-date"><?php _e('about ','avis');?><?php echo human_time_diff($t['time'], current_time('timestamp')); ?><?php _e(' ago','avis');?></span></div>
							</li>
						<?php endforeach; ?>
						<?php } else { ?><div class="twiiter-error"><?php _e("Please Configure the twitter section in admin : Avis Options > Twitter Slider",'avis'); ?></div><?php } ?>
					</ul>
				</div>
				<i class="fa fa-twitter">&nbsp;</i>
			</div>
			<div class="nav"></div>

			<script type="text/javascript">
				jQuery(window).load(function () {
					jQuery('.tw-slider').flexslider({
						animation: "<?php echo $_tws_effect; ?>",
						namespace: "foot-tw-",	//{NEW} String: Prefix string attached to the class of every element generated by the plugin
						selector: ".slides > li", //{NEW} Selector: Must match a simple pattern. '{container} > {slide}' -- Ignore pattern at your own peril
						easing: "swing",		  //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
						direction: "horizontal",
						slideshow: <?php echo $_tws_autoplay; ?>,
						slideshowSpeed: <?php echo $_tws_delay; ?>,//Integer: Set the speed of the slideshow cycling, in milliseconds
						animationSpeed: <?php echo $_tws_speed; ?>,//Integer: Set the speed of animations, in milliseconds
						controlsContainer: "",
						controlNav: false,  //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
						directionNav: false, //Boolean: Create navigation for previous/next navigation? (true/false)
						prevText: "",		//String: Set the text for the "previous" directionNav item
						nextText: "",
						pauseOnHover: <?php echo $_tws_pause; ?>
					});
				});
			</script>
	</div> 

		 </div>
	</div>
</div>
<?php } ?>
<!-- .twitter slider section ends -->
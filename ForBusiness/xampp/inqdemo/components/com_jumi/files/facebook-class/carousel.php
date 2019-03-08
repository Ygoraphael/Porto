<?php

/**
* @version   $Id$
* @package   
* @copyright 
* @license   GNU/GPL v3 http://www.gnu.org/licenses/gpl.html
*/

//includes
namespace seoFacebookTimeline;
include_once('facebook/lib/facebookFunctions.php');
include_once('facebook/lib/facebookTimeline.php');
include_once('facebook/lib/facebookItem.php');
include_once('facebook/lib/facebookComment.php');
include_once('facebook/lib/language.php');


/**
* 
*/

# New Timeline
$tl = new timeline(
'academiadoprofissional', // username or id
'28f7b3704463fbeaa0f694442ebdd703', // facebook tokenId
'9b2bcd5e773eeccb9c84ec44575a8486' // facebook tokenSecret
);
$tl->setMaxItems(4); //How many items (Don't use to many. preferred 30,40 or 50)
$tl->setNewsType('posts'); //Feed or Posts
$tl->setNewsFilter(true); //Filter only posts if it contains text (so no status updates)
$tl->setShowImages(true); //Show images on posts
$tl->setHrImages(true); //Higher resolution images ? Lazy loading will prevent slowing down your website
$tl->setShowComments(true); //Show Comments
$tl->setMaxComments(10); //Maximum comments to show (Don't use to many. preferred 10)
$tl->setCacheLife(21600); //Cache life in seconds. Cache is disabled when set to "0".
$tl->setCacheDirectory('./facebook/cache/'); //cache directory
$tl->setBullets(false); //Show bullets and timeline stripe divider
$tl->setDebug(true);
# Language
$lang = new language(); //Here you translation
$lang->setTitle('NEWS');
$lang->setShareOnTwitter('Share on Twitter');
$lang->setShareOnLinkedIn('Share on LinkedIn');
$lang->setshareOnFacebook('Share on Facebook');
$lang->setShareOnGooglePlus('Share on Google+');
$lang->setComment('Comment or like !');
$lang->setShowComments('Show comments');
$lang->setBy('by');
$lang->setDatePrefix('');
$lang->setSecondsAgo(' seconds ago');
$lang->setMinuteAgo(' minute ago');
$lang->setMinutesAgo(' minutes ago');
$lang->setHourAgo(' hour ago');
$lang->setHoursAgo(' hours ago');
$lang->setDayAgo(' day ago');
$lang->setDaysAgo(' days ago');
$lang->setWeekAgo(' week ago');
$lang->setWeeksAgo(' weeks ago');


/**
* 
*/

echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<title>Bootstrap Example</title>';
echo '<meta charset="utf-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
  
echo '<link rel="stylesheet" href="./facebook/css/timeline.css">';
echo '<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>';
echo '<script defer src="./facebook/js/jquery.lazyload.min.js"></script>';
echo '<script src="./facebook/js/timeline.js"></script>';
    
echo '</head>';
echo '<body>';
echo '<div class="container">';
echo '<h2>Carousel Example</h2>';  
echo '<div id="myCarousel" class="carousel slide" data-ride="carousel">';

echo '<ol class="carousel-indicators">';
			$items = count($tl);
			for ($i = 1; $i <= $items; $i++) {
				echo '<li data-target="#myCarousel" data-slide-to="'.$i.'"></li>';
			}
		
echo '</ol>';

echo '<div class="carousel-inner">';
		foreach ($tl->getItems() as &$facebookItem) {
				echo '<div class="item">';
				echo $facebookItem;
				echo '';
				echo '</div>';
		};
		
echo '</div>';

    
    echo '<a class="left carousel-control" href="#myCarousel" data-slide="prev">';
      echo '<span class="glyphicon glyphicon-chevron-left"></span>';
      echo '<span class="sr-only">Previous</span>';
    echo '</a>';
    echo '<a class="right carousel-control" href="#myCarousel" data-slide="next">';
      echo '<span class="glyphicon glyphicon-chevron-right"></span>';
      echo '<span class="sr-only">Next</span>';
    echo '</a>';
  echo '</div>';
echo '</div>';

echo '</body>';
echo '</html>';
?>
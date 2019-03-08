Social Seo Facebook Posts responsive timeline PHP class

Requires PHP 5.3x and Curl or url fopen. It is coded using PHP 5 OOP

You can only use public pages. To test if your facebook page can be used try here https://developers.facebook.com/tools/explorer/ and change me in your facebook name or page ID.
All posts are set to rich snippets for better SEO

Unzip the file

Open index.php
here you will find all the settings which you can use to set up the facebook SEO timeline
and what is needed to include

<?php
//includes
namespace seoFacebookTimeline;
include_once('facebook/lib/facebookFunctions.php');
include_once('facebook/lib/facebookTimeline.php');
include_once('facebook/lib/facebookItem.php');
include_once('facebook/lib/facebookComment.php');
include_once('facebook/lib/language.php');
?>

# New Timeline
$tl = new timeline (
'', // username or id
'', // facebook tokenId
'' // facebook tokenSecret
);
  $tl->setMaxItems(20); //How many items (Don't use to many. preferred 30,40 or 50)
  $tl->setNewsType('posts'); //Feed or Posts
  $tl->setNewsFilter(true); //Filter only posts if it contains text (so no status updates)
  $tl->setShowImages(true); //Show images on posts
  $tl->setHrImages(true); //Higher resolution images ? Lazy loading will prevent slowing down your website
  $tl->setShowComments(true); //Show Comments
  $tl->setMaxComments(10); //Maximum comments to show (Don't use to many. preferred 10)
  $tl->setCacheLife(21600); //Cache life in seconds. Cache is disabled when set to "0".
  $tl->setCacheDirectory('./facebook/cache/'); //cache directory
  $tl->setBullets(false); //Show bullets and timeline stripe divider
  $tl->setDebug(true); //Set debug to true to see the json url. For testing only

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

After these settings you will get the timeline
Copy and paste till <!-- END Timeline -->

For the Token id and Token secret you need to make an app at the facebook dev site. Look at this video https://www.youtube.com/watch?v=HIf0JW7JhcE to get one and go to the https://developers.facebook.com/ website


Also needed

<!-- needed CSS -->
<link rel="stylesheet" href="./facebook/css/timeline.css">
<!-- END needed CSS -->

<!-- needed JS -->
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script defer src="./facebook/js/jquery.lazyload.min.js"></script>
<script src="./facebook/js/timeline.js"></script>
<!-- END needed JS -->


Good luck with this plugin

Ceasar Feijen



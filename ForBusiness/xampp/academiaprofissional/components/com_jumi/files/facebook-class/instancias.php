<?php

/**
* @version   $Id$
* @package   Jumi
* @copyright (C) 2008 - 2011 Edvard Ananyan
* @license   GNU/GPL v3 http://www.gnu.org/licenses/gpl.html
*/

# New Timeline
$tl = new timeline (
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

?>
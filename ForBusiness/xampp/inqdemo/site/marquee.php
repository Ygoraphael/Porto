<?php

namespace seoFacebookTimeline;

date_default_timezone_set('Europe/Lisbon');
include_once('facebook/lib/facebookFunctions.php');
include_once('facebook/lib/facebookTimeline.php');
include_once('facebook/lib/facebookItem.php');
include_once('facebook/lib/facebookComment.php');
include_once('facebook/lib/language.php');
$tl = new timeline(
        '782410891841659', // username or id
        '1830944233836695', // facebook tokenId
        '9b2bcd5e773eeccb9c84ec44575a8486' // facebook tokenSecret
);
$tl->setMaxItems(20); //How many items (Don't use to many. preferred 30,40 or 50)
$tl->setNewsType('posts'); //Feed or Posts
$tl->setNewsFilter(true); //Filter only posts if it contains text (so no status updates)
$tl->setShowImages(true); //Show images on posts
$tl->setHrImages(true); //Higher resolution images ? Lazy loading will prevent slowing down your website
$tl->setShowComments(true); //Show Comments
$tl->setMaxComments(10); //Maximum comments to show (Don't use to many. preferred 10)
$tl->setCacheLife(21000); //Cache life in seconds. Cache is disabled when set to "0".
$tl->setCacheDirectory('./facebook/cache/'); //cache directory
$tl->setBullets(true); //Show bullets and timeline stripe divider
$tl->setDebug(false); //Set debug to true to see the json url. For testing only
# Language
$lang = new language();

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

$tl->setLanguage($lang);

$bulls = ($tl->getBullets() ? '' : ' timeline-nobullets');
?>

<style style="text/css">
    .color2-ms:nth-child(2) {
    background: red;
    }
    #jm-bar-left{
        padding: 2px;
    }
    #jm-breadcrumbs{
        display:none !important;
    }
    #jm-bar-right{
        padding: 0px;
    }
    .marquee {
        padding: 0px 30px;
        font-size: 16px;
        height: 20px;
        overflow: hidden;
        position: relative;
        background: #2db4e2;
        color: #fbfbfb;
        border: 1px solid #4495b1;
    }
    .marquee li {
        position: absolute;
        width: 100%;
        height: 100%;
        margin: 0;
        line-height: 20px;
        text-align: center;
        /* Starting position */
        -moz-transform:translateX(100%);
        -webkit-transform:translateX(100%);	
        transform:translateX(100%);
        /* Apply animation to this element */	
        -moz-animation: scroll-left 18s linear infinite;
        -webkit-animation: scroll-left 18s linear infinite;
        animation: scroll-left 18s linear infinite;
    }
    .marquee li a{
        color: #fbfbfb;
        margin-right: 400px;
    }
    .marquee li a:hover{
        text-decoration: none;
        color:#0077b3;
    }
    /* Move it (define the animation) */
    @-moz-keyframes scroll-left {
        0%   { -moz-transform: translateX(100%); }
        100% { -moz-transform: translateX(-100%); }
    }
    @-webkit-keyframes scroll-left {
        0%   { -webkit-transform: translateX(100%); }
        100% { -webkit-transform: translateX(-100%); }
    }
    @keyframes scroll-left {
        0%   { 
            -moz-transform: translateX(100%); /* Browser bug fix */
            -webkit-transform: translateX(100%); /* Browser bug fix */
            transform: translateX(100%); 		
        }
        100% { 
            -moz-transform: translateX(-100%); /* Browser bug fix */
            -webkit-transform: translateX(-100%); /* Browser bug fix */
            transform: translateX(-100%); 
        }
    }
</style>
<ul class="marquee">
    <li>
        <?php
        $items = $tl->getItems();
        foreach ($items as $item) {
            echo "<a href='/inqdemo/index.php?option=com_jumi&view=application&fileid=12'>" . substr($item->getContent(), 0, 50) . "...</a>";
        }
        ?>
    </li>
</ul>
<br>
<div id="conteudo">
    
</div>

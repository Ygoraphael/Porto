<?php
//includes

namespace seoFacebookTimeline;

date_default_timezone_set('Europe/Lisbon');
//includes
include_once('facebook/lib/facebookFunctions.php');
include_once('facebook/lib/facebookTimeline.php');
include_once('facebook/lib/facebookItem.php');
include_once('facebook/lib/facebookComment.php');
include_once('facebook/lib/language.php');
?>

<div class="container">

    <!-- Timeline class begin -->
    <?php
    # New Timeline
    # Version 2.0
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


    $yearclass = ($tl->escape($tl->getLanguage()->getTitle()) == '' ? ' notitle' : '');
    $items = $tl->getItems();
    $i = 0;
    foreach ($items as $item) {
        $tag = 'Formação';
        $worlds = explode(' ', $item->getName());
        if ((in_array($tag, $worlds)) && ($i < 10)) {

            $image = $item->getImage();
            $video = $item->getVideo();
            $mp4video = $item->getMP4Video();
            $soundcloud = $item->getSoundcloud();
            $rtol = ($tl->is_rtl($tl->escape($item->getContent(), true)) ? ' dir="rtl"' : '');
            $rtolc = ($tl->is_rtl($tl->escape($item->getSharedStoryCaption())) ? ' dir="rtl"' : '');
            $rtoll = ($tl->is_rtl($tl->escape($item->getSharedStoryName())) ? ' dir="rtl"' : '');
            $rtold = ($tl->is_rtl($tl->escape($item->getSharedStoryDescription(), true)) ? ' dir="rtl"' : '');
            ?>
            <br>
            <div style="border-bottom: 1px dotted #CCC">
                <?php
                echo
                ($image != '' && $mp4video != '' ? '<div class="timeline-video">' . $mp4video . '</div>' : '') . '
                    ' . ($video != '' ? '<div class="timeline-video">' . $video . '</div>' : '') . '
					' . ($soundcloud != '' ? '<div class="timeline-image">' . $soundcloud . '</div>' : '') . '
                    ' . ($image != '' && $video == '' && $mp4video == '' && $soundcloud == '' ? '<div style="float:left" itemprop="image" class="timeline-image"><a href="https://www.facebook.com/' . $tl->getUsername() . '/posts/' . $item->getId() . '" target="_blank">' . $image . '</a></div>' : '');
                ?>
                <h3 style="margin-left: 150px"><?php echo '<a href="https://www.facebook.com/' . $tl->getUsername() . '/posts/' . $item->getId() . '" target="_blank">' . $item->getName() . '</a>' ?></h3>
                <?php echo '<div class="" itemprop="articleBody" style="margin-left: 150px"' . $rtol . '>' . $tl->nl2br2($tl->escape($item->getContent(), true)) . '<br><br><i>' . (new \DateTime($item->getCreatedPublished()))->format('d/m/Y H:i') . '</i></div>' ?>
                <div ></div>
                <br><br>
            </div>
            <?php
            $i++;
        }
    }
    ?>
    <!-- END Timeline -->
</div>
<!-- needed JS -->
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script defer src="facebook/js/jquery.lazyload.min.js"></script>
<script src="facebook/js/timeline.js"></script>
<!-- END needed JS -->
<script async data-pin-shape="round" data-pin-height="32" data-pin-hover="true" src="//assets.pinterest.com/js/pinit.js"></script>

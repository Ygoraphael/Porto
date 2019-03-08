<?php
    //includes
	namespace seoFacebookTimeline;
    include_once('facebook/lib/facebookFunctions.php');
    include_once('facebook/lib/facebookTimeline.php');
    include_once('facebook/lib/facebookItem.php');
    include_once('facebook/lib/facebookComment.php');
    include_once('facebook/lib/language.php');
?>
<!doctype html>
<html lang="en-US">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Responsive facebook Timeline php class</title>

<!-- needed CSS -->
<link rel="stylesheet" href="facebook/css/timeline.css">
<!-- END needed CSS -->

</head>

<body>
<div class="container">
  <header class="page-header">
    <h1>Responsive Seo facebook Timeline php OOP class</h1>
  </header>
  <div class="divider"></div>

<!-- Timeline class begin -->
<?php
	# New Timeline
	# Version 2.0
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

	echo '<ul class="timeline' . $bulls . '">';

	$yearclass = ($tl->escape($tl->getLanguage()->getTitle()) == '' ? ' notitle' : '');

    echo '<li class="year' . $yearclass . '">' . $tl->escape($tl->getLanguage()->getTitle()) . '</li>';

    $items = $tl->getItems();
    foreach($items as $item){
        $image = $item->getImage();
        $video = $item->getVideo();
		$mp4video = $item->getMP4Video();
		$soundcloud = $item->getSoundcloud();
        $rtol = ($tl->is_rtl($tl->escape($item->getContent(),true)) ? ' dir="rtl"' : '');
		$rtolc = ($tl->is_rtl($tl->escape($item->getSharedStoryCaption())) ? ' dir="rtl"' : '');
		$rtoll = ($tl->is_rtl($tl->escape($item->getSharedStoryName())) ? ' dir="rtl"' : '');
		$rtold = ($tl->is_rtl($tl->escape($item->getSharedStoryDescription(),true)) ? ' dir="rtl"' : '');
        echo '<li class="timeline-event' . $bulls . '">
                <div class="timeline-post" itemscope itemtype="http://schema.org/Article">
                    <h3>' . $tl->formatDateTime($item->getCreatedAt()) . ' ' . $tl->escape($tl->getLanguage()->getBy()) . ' <a itemprop="publisher" title="'.$tl->escape($tl->getProfileName()).'" href="https://www.facebook.com/'.$tl->escape($tl->getUsername()).'?hc_location=timeline" target="_blank"><span itemprop="name">' .$tl->escape($tl->getProfileName()) . '</span></a></h3>
					<meta itemprop="datePublished" content="' . $tl->escape($item->getCreatedPublished()) . '">
                    <img class="img-rounded timeline-avatar" src="' . $tl->escape($tl->getProfileImageURL()) . '" width="50" height="50" alt="' . $tl->escape($tl->getProfileName()) . '">
					<meta itemprop="headline" content="' . strip_tags(substr($tl->escape($item->getContent(),true), 0, 110)) . '">
					<div class="timeline-content" itemprop="articleBody"' . $rtol . '>' . $tl->nl2br2($tl->escape($item->getContent(),true)) . '</div>
                    <div class="timeline-divider"></div>
					' . ($image != '' && $mp4video != '' ? '<div class="timeline-video">' . $mp4video . '</div>' : '') . '
                    ' . ($video != '' ? '<div class="timeline-video">' . $video . '</div>' : '') . '
					' . ($soundcloud != '' ? '<div class="timeline-image">' . $soundcloud . '</div>' : '') . '
                    ' . ($image != '' && $video == '' && $mp4video == '' && $soundcloud == '' ? '<div itemprop="image" class="timeline-image"><a href="https://www.facebook.com/'.$tl->getUsername().'/posts/'.$item->getId().'" target="_blank">' . $image . '</a></div>' : '');

        # Shared story
        if($item->getSharedStory() == true){
            echo  '<div class="timeline-link">
                    <h5><a itemprop="url" href="' . $tl->escape($item->getSharedStoryLink()) . '" target="_blank"><span itemprop="name" class="timeline-inline"' . $rtoll . '>' . $tl->escape($item->getSharedStoryName()) . '</span></a></h5>' .
                ($item->getSharedStoryCaption() != null ? '<div class="timeline-caption"' . $rtolc . '>' . str_replace(array("\n\n","\n","\\n","\\n\\n"),"<br>",$tl->escape($item->getSharedStoryCaption())) . '</div>' : '') .
                ($item->getSharedStoryDescription() != null ? '<div class="timeline-description"' . $rtold . '>' . $tl->nl2br2($tl->escape($item->getSharedStoryDescription(),true)) . '</div>' : '') .
                '</div>';
        }
        # Comments
        foreach($item->getComments() as $comment){
            $rtolc = ($tl->is_rtl($tl->escape($comment->getMessage(),true)) ? ' dir="rtl"' : '');
			$rtoln = ($tl->is_rtl($tl->escape($comment->getName())) ? ' dir="rtl"' : '');
			echo '<div class="timeline-comments">
                <i>' . $tl->formatDateTime($comment->getCreatedAt()) . '</i>
                <strong><a href="https://www.facebook.com/app_scoped_user_id/' . $tl->escape($comment->getUserId()) . '" target="_blank" rel="nofollow"><span' . $rtoln . '>' . $tl->escape($comment->getName()) . '</span></a></strong>
                ' . ($comment->getLikeCount() > 0 ? '' . $tl->escape($comment->getLikeCount()) . ' <span class="timelineicon-thumbs-o-up thumbsup"></span><br>' : '<br>') .
                '<span' . $rtolc . ' class="timeline-inline">' . $tl->nl2br2($tl->escape($comment->getMessage(),true)) . '</span>';

            # Subcomments
			$subcomments = $comment->getComments();
            foreach($subcomments as $subcomment){
                $rtolc = ($tl->is_rtl($tl->escape($subcomment->getMessage(),true)) ? ' dir="rtl"' : '');
                $rtoln = ($tl->is_rtl($tl->escape($subcomment->getName())) ? ' dir="rtl"' : '');
			    if ($subcomment === reset($subcomments)){
			        $replyitem = '<span class="timelineicon-forward"></span>';
				}else{
					$replyitem = '';
			    }
				echo $replyitem;
				echo '<div class="timeline-comments subcomments">
                <i>' . $tl->formatDateTime($subcomment->getCreatedAt()) . '</i>
                <strong><a href="https://www.facebook.com/app_scoped_user_id/' . $tl->escape($subcomment->getUserId()) . '" target="_blank" rel="nofollow"><span' . $rtoln . '>' . $tl->escape($subcomment->getName()) . '</span></a></strong>
                ' . ($subcomment->getLikeCount() > 0 ? '' . $tl->escape($subcomment->getLikeCount()) . ' <span class="timelineicon-thumbs-up thumbsup"></span><br>' : '<br>') .
                    '<span' . $rtolc . ' class="timeline-inline">' . $tl->nl2br2($tl->escape($subcomment->getMessage(),true)) . '</span>';
                echo '</div>';
            }

            echo '</div>';
        }

		echo '<div class="timeline-share"><div class="timeline-likes">';

        # Likes
        echo '<a href="https://www.facebook.com/'.$tl->getUsername().'/posts/'.$item->getId().'" title="' . $lang->getComment() . '" target="_blank"><span class="timeline-count">' . ($item->getLikesCount() > 0 ? $item->getLikesCount() : '') . '</span> <span class="timelineicon-thumbs-up sharebutton"></span></a>';

        # Comment count
        if($tl->getShowComments() && $item->getCommentsCount() > 0){
            echo '<a class="timeline-commenttitle" href="#" title="' . $tl->escape($tl->getLanguage()->getShowComments()) . '"><span class="timeline-count">' . $item->getCommentsCount() . '</span> <span class="timeline-cicon timelineicon-comment sharebutton"></span></a>';
        }

        echo '</div>';

        # Check which type post
		if ($item->getType() == 'photo' || $item->getType() == 'video') {
        	$facebooklink = urlencode($item->getSharedStoryLink());
		} else {
        	$facebooklink = urlencode($item->getShareURL());
		}

        # Share
        echo '<a href="https://www.facebook.com/sharer/sharer.php?u='.$facebooklink.'" title="' . $tl->escape($lang->getShareOnFacebook()) . '" onclick="window.open(this.href, \'myshare\',\'left=20,top=20,width=650,height=500,toolbar=1,resizable=0\'); return false;"><span class="timelineicon-facebook-square sharebutton"></span></a>
			  <a href="https://plus.google.com/share?url=' . urlencode($item->getShareURL()) . '&amp;t=' . urlencode($item->getName()) . '" title="' . $tl->escape($lang->getShareOnGooglePlus()) . '" onclick="window.open(this.href, \'myshare\',\'left=20,top=20,width=500,height=325,toolbar=1,resizable=0\'); return false;"><span class="timelineicon-google-plus-square sharebutton"></span></a>
        	  <a href="https://twitter.com/share?url=' . urlencode($item->getShareURL()) . '&amp;text=' . urlencode($item->getName()) . '" title="' . $tl->escape($lang->getShareOnTwitter()) . '" onclick="window.open(this.href, \'myshare\',\'left=20,top=20,width=500,height=325,toolbar=1,resizable=0\'); return false;"><span class="timelineicon-twitter-square sharebutton"></span></a>
        	  <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=' . urlencode($item->getShareURL()) . '&amp;title=' . urlencode($item->getName()) . '&source=' . urlencode($tl->getProfileName()) . '" title="' . $tl->escape($lang->getShareOnLinkedIn()) . '" onclick="window.open(this.href, \'myshare\',\'left=20,top=20,width=600,height=520,toolbar=1,resizable=1\');return false;"><span class="timelineicon-linkedin-square sharebutton"></span></a>
		';

        echo '</div></div>';
        echo '</li>';
    }
?>
</ul>
<!-- END Timeline -->
</div>
<!-- needed JS -->
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script defer src="facebook/js/jquery.lazyload.min.js"></script>
<script src="facebook/js/timeline.js"></script>
<!-- END needed JS -->
<script async data-pin-shape="round" data-pin-height="32" data-pin-hover="true" src="//assets.pinterest.com/js/pinit.js"></script>
</body>
</html>
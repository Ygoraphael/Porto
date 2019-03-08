<?php
    namespace seoFacebookTimeline;


    /**
     * Make clickable links from URLs in text.
     */
    function _make_url_clickable_cb($matches) {
        $ret = '';
        $url = $matches[2];
        if ( empty($url) )
            return $matches[0];
        // removed trailing [.,;:] from URL
        if ( in_array(substr($url, -1), array('.', ',', ';', ':')) === true ) {
            $ret = substr($url, -1);
            $url = substr($url, 0, strlen($url)-1);
        }
		$out = preg_replace('/(?<=^.{20}).{4,}(?=.{16}$)/', '...', $url);
        return $matches[1] . "<a href=\"$url\" target=\"_blank\">$out</a>" . $ret;
    }
    function _make_web_ftp_clickable_cb($matches) {
        $ret = '';
        $dest = $matches[2];
        $dest = 'http://' . $dest;
        if ( empty($dest) )
            return $matches[0];
        // removed trailing [,;:] from URL
        if ( in_array(substr($dest, -1), array('.', ',', ';', ':')) === true ) {
            $ret = substr($dest, -1);
            $dest = substr($dest, 0, strlen($dest)-1);
        }
        return $matches[1] . "<a href=\"$dest\" target=\"_blank\">$dest</a>" . $ret;
    }
    function _make_email_clickable_cb($matches) {
        $email = $matches[2] . '@' . $matches[3];
        return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
    }
    function make_clickable($ret) {
        $ret = ' ' . $ret;
        // in testing, using arrays here was found to be faster
        $ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '\seoFacebookTimeline\_make_url_clickable_cb', $ret);
        $ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '\seoFacebookTimeline\_make_web_ftp_clickable_cb', $ret);
        $ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', '\seoFacebookTimeline\_make_email_clickable_cb', $ret);
        // this one is not in an array because we need it to run last, for cleanup of accidental links within links
        $ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);
        $ret = trim($ret);
        return $ret;
    }

	function checkRemoteFile($url)
	{
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_NOBODY, 1);
	    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    if(curl_exec($ch)!==FALSE)
	    {
	        return true;
	    }
	    else
	    {
	        return false;
	    }
	}


    /**
     * Add rel nofollow for better SEO.
     */
    function rel_nofollow( $text ) {
        $text = preg_replace_callback('|<a (.+?)>|i', '\seoFacebookTimeline\rel_nofollow_callback', $text);
        return $text;
    }
    function rel_nofollow_callback( $matches ) {
        $text = $matches[1];
        $text = str_replace(array(' rel="nofollow"', " rel='nofollow'"), '', $text);
        return "<a $text rel=\"nofollow\">";
    }

	/**
	 * Show soundcloud.
	 */
    function embedSoundcloud($url) {
        $url = str_replace('http://player.soundcloud.com/player.swf','https://w.soundcloud.com/player/',$url);
		return '<iframe class="cff-soundcloud" width="100%" height="300" frameborder="no" src="'.$url.'" scrolling="no"></iframe>';
    }

    /**
     * Embed youtube
     * @param $url
     * @return string $html
     */
    function embedYoutube($url){
        $search = '%
            (?:https?://)?
            (?:www\.)?
            (?:
              youtu\.be/
            | youtube\.com
              (?:
                /embed/
              | /v/
              | /watch\?v=
              )
            )
            ([\w\-]{10,12})
            (.*)
            %x';
        $replace = '<iframe class="yt_players" id="$1" src="https://www.youtube.com/embed/$1?showinfo=0&autoplay=0&modestbranding=1&autohide=1&rel=0&fs=1&controls=1&theme=light&iv_load_policy=3&wmode=opaque&enablejsapi=1" frameborder="0" allowfullscreen></iframe>';
        return preg_replace($search, $replace, $url);
    }

    /**
     * Convert facebook hashtags.
     */
    function make_hashtag($strHash) {
        $strHash = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '\1#<a href="https://www.facebook.com/hashtag/\2?source=feed_text" title="\2" rel="nofollow">\2</a>', $strHash);
        return $strHash;
    }
<?php

namespace seoFacebookTimeline;

class timeline {

    protected $username = null;
    protected $profileName;
    protected $profileImageURL;
    protected $tokenId = null;
    protected $tokenSecret = null;
    protected $maxItems = '30';
    protected $newsType = 'posts';
    protected $newsFilter = true;
    protected $showImages = true;
    protected $hrImages = true;
    protected $showComments = true;
    protected $maxComments = 10;
    protected $outputFeed = true;
    protected $cacheLife = 86400;
    protected $cacheDirectory = './cache/';
    protected $bullets = true;

    /** @var \seoFacebookTimeline\language */
    protected $language;

    /**
     * @param $username
     * @param $tokenId
     * @param $tokenSecret
     */
    public function __construct($username, $tokenId, $tokenSecret) {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username cannot be empty');
        }
        if (empty($tokenId)) {
            throw new \InvalidArgumentException('tokenId cannot be empty');
        }
        if (empty($tokenSecret)) {
            throw new \InvalidArgumentException('tokenSecret cannot be empty');
        }

        $this->setUsername($username);
        $this->setTokenId($tokenId);
        $this->setTokenSecret($tokenSecret);
    }

    /**
     * Get all the items
     * @return array|facebookItem[]
     * @throws \Exception
     */
    public function getItems() {
        # URL
        $url = 'https://graph.facebook.com/v2.9/' . $this->username . '?fields=name,picture,' . $this->newsType . '.limit(' . $this->maxItems . '){' . ($this->showComments ? 'comments.limit(' . $this->maxComments . ').summary(true){like_count,message,created_time,from,comments.limit(' . $this->maxComments . ').summary(true){like_count,message,created_time,from}},' : '') . 'name,object_id,description,message,type,link,caption,id,created_time,full_picture,source,picture,status_type,story,attachments,likes.limit(1).summary(true)}&access_token=' . $this->tokenId . '|' . $this->tokenSecret;

        //Check if url is okay
        if ($this->debug) {
            print_r($url);
        }

        # Load from cache
        $filename = $this->cacheDirectory . $this->username . '.json';
        if (file_exists($filename) && filesize($filename) > 0 && filemtime($filename) > time() - $this->cacheLife) {
            $json = file_get_contents($filename);
        } else {
            $json = $this->urlGetContents($url);
            file_put_contents($filename, $json);
        }

        # Error
        if ($json === false || $json == '') {
            throw new \Exception('Loaded JSON is empty');
        }

        # Decode
        $json = json_decode($json, true);

        # Profile name   !isset($json[$this->newsType]['data'])
        if (!isset($json['name'])) {
            echo '<br><br>The user ' . $this->username . ' does not exists !<br><br>';
            @unlink($filename);
            throw new \Exception('JSON is empty');
        }
        $this->setProfileName($json['name']);

        # Profile image
        $this->setProfileImageURL($json['picture']['data']['url']);

        # Empty
        if (!isset($json[$this->newsType]['data']) || !is_array($json[$this->newsType]['data'])) {
            return array();
        }

        # Items
        /** @var facebookItem[] $items */
        $items = array();
        $data = $json[$this->newsType]['data'];
        $done = array();
        $i = 1;
        foreach ($data as $item) {
            if (isset($item['id']) && $item['id'] != '' && in_array($item['id'], $done)) {
                continue;
            }
            $done[] = $item['id'];
            if ($this->getNewsFilter() && !isset($item['message'])) {
                continue;
            }
            $facebookItem = new facebookItem($this);
            $facebookItem->load($item);
            $items[] = $facebookItem;
            if ($i++ >= $this->maxItems) {
                break;
            }
        }

        # Return
        return $items;
    }

    /**
     * Get content from URL
     * @param $url
     * @return mixed|string
     */
    public function urlGetContents($url) {
        if (function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec') && function_exists('curl_exec')) {
            # Use cURL
            $curl = curl_init($url);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);
            if (stripos($url, 'https:') !== false) {
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            }

            $content = @curl_exec($curl);
            curl_close($curl);
        } else {
            # Use FGC, because cURL is not supported
            ini_set('default_socket_timeout', 5);
            $content = @file_get_contents($url);
        }
        return $content;
    }

    /**
     * @param null $string
     * @param boolean $parse = false
     */
    public function escape($string, $parse = false) {
        if ($parse) {
            return rel_nofollow(make_clickable(make_hashtag(htmlspecialchars($string, ENT_COMPAT, 'UTF-8'))));
        } else {
            return htmlspecialchars($string, ENT_COMPAT, 'UTF-8');
        }
    }

    /**
     * Replace \n to <br>.
     */
    public function nl2br2($string) {
        $string = preg_replace("/(\n){3,}/", "\n\n", trim($string));
        $string = preg_replace("/ +/", " ", $string);
        $string = preg_replace("/^ +/", "", $string);
        $string = str_replace(array("\r\n", "\r", "\n"), "<br>", $string);
        $string = preg_replace('#(?:<br\s*/?>\s*?){2,}#', '<span class="timeline-break">&nbsp;</span>', $string);
        return $string;
    }

    /**
     * Is RTL
     * Check if there RTL characters (Arabic, Persian, Hebrew)
     *
     * @author	Khaled Attia <sourcecode@khal3d.com>
     * @param	String	$string
     * @return	bool
     */
    public function is_rtl($string) {
        $rtl_chars_pattern = '/[\x{0590}-\x{05ff}\x{0600}-\x{06ff}]/u';
        return preg_match($rtl_chars_pattern, $string);
    }

    /**
     * Get time function.
     */
    public function formatDateTime(\DateTime $sDate = null) {
        if ($sDate === null) {
            return null;
        }
        $timestamp = $sDate->getTimestamp();
        $now = time();
        $timediff = floor($now - $timestamp);
        $language = $this->getLanguage();

        switch (true) {
            case ($timediff < 60):
                return $timediff . $language->getSecondsAgo();

            case($timediff >= 60 && $timediff < 120):
                return $language->getDatePrefix() . floor($timediff / 60) . $language->getMinuteAgo();

            case($timediff >= 120 && $timediff < 3600):
                return $language->getDatePrefix() . floor($timediff / 60) . $language->getMinutesAgo();

            case($timediff >= 3600 && $timediff < 7200):
                return $language->getDatePrefix() . floor($timediff / 3600) . $language->getHourAgo();

            case($timediff >= 7200 && $timediff < 86400):
                return $language->getDatePrefix() . floor($timediff / 3600) . $language->getHoursAgo();

            case($timediff >= 86400 && $timediff < 172800):
                return $language->getDatePrefix() . floor($timediff / 86400) . $language->getDayAgo();

            case($timediff >= 172800 && $timediff < 602800):
                return $language->getDatePrefix() . floor($timediff / 86400) . $language->getDaysAgo();

            case($timediff >= 602800 && $timediff < 1209600):
                return $language->getDatePrefix() . floor($timediff / 602800) . $language->getWeekAgo();

            case($timediff >= 1209600):
                return $language->getDatePrefix() . floor($timediff / 602800) . $language->getWeeksAgo();
        }
    }

    /**
     * @param mixed $profileImageURL
     */
    public function setProfileImageURL($profileImageURL) {
        $this->profileImageURL = $profileImageURL;
    }

    /**
     * @return mixed
     */
    public function getProfileImageURL() {
        return $this->profileImageURL;
    }

    /**
     * @param mixed $profileName
     */
    public function setProfileName($profileName) {
        $this->profileName = $profileName;
    }

    /**
     * @return mixed
     */
    public function getProfileName() {
        return $this->profileName;
    }

    /**
     * @param string $cacheDirectory
     */
    public function setCacheDirectory($cacheDirectory) {
        $this->cacheDirectory = $cacheDirectory;
    }

    /**
     * @param int $cacheLife
     */
    public function setCacheLife($cacheLife) {
        $this->cacheLife = $cacheLife;
    }

    /**
     * @param int $cacheLife
     */
    public function getCacheLife() {
        return $this->cacheLife;
    }

    /**
     * @return mixed
     */
    public function getBullets() {
        return $this->bullets;
    }

    /**
     * @param mixed $bullets
     */
    public function setBullets($bullets) {
        $this->bullets = $bullets;
    }

    /**
     * @return mixed
     */
    public function getDebug() {
        return $this->debug;
    }

    /**
     * @param mixed $debug
     */
    public function setDebug($debug) {
        $this->debug = $debug;
    }

    /**
     * @return int
     */
    public function getMaxComments() {
        return $this->maxComments;
    }

    /**
     * @return boolean
     */
    public function getShowComments() {
        return $this->showComments;
    }

    /**
     * @return boolean
     */
    public function getShowImages() {
        return $this->showImages;
    }

    /**
     * @return boolean
     */
    public function getHrImages() {
        return $this->hrImages;
    }

    /**
     * @param boolean $hrImages
     */
    public function setHrImages($hrImages) {
        $this->hrImages = $hrImages;
    }

    /**
     * @return boolean
     */
    public function getNewsFilter() {
        return $this->newsFilter;
    }

    /**
     * @param boolean $newsFilter
     */
    public function setNewsFilter($newsFilter) {
        $this->newsFilter = $newsFilter;
    }

    /**
     * @param int $maxComments
     */
    public function setMaxComments($maxComments) {
        $this->maxComments = $maxComments;
    }

    /**
     * @param string $maxItems
     */
    public function setMaxItems($maxItems) {
        $this->maxItems = $maxItems;
    }

    /**
     * @param string $newsType
     */
    public function setNewsType($newsType) {
        $this->newsType = $newsType;
    }

    /**
     * @param boolean $outputFeed
     */
    public function setOutputFeed($outputFeed) {
        $this->outputFeed = $outputFeed;
    }

    /**
     * @param boolean $showComments
     */
    public function setShowComments($showComments) {
        $this->showComments = $showComments;
    }

    /**
     * @param boolean $showImages
     */
    public function setShowImages($showImages) {
        $this->showImages = $showImages;
    }

    /**
     * @param null $tokenId
     */
    public function setTokenId($tokenId) {
        $this->tokenId = $tokenId;
    }

    /**
     * @param null $tokenSecret
     */
    public function setTokenSecret($tokenSecret) {
        $this->tokenSecret = $tokenSecret;
    }

    /**
     * @param null $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return null
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param \seoFacebookTimeline\language $language
     */
    public function setLanguage($language) {
        $this->language = $language;
    }

    /**
     * @return \seoFacebookTimeline\language
     */
    public function getLanguage() {
        return $this->language;
    }

}

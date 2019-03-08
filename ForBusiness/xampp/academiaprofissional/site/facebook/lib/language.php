<?php
    namespace seoFacebookTimeline;

    class language {
        public $title = 'NEWS';
		public $shareOnTwitter = 'Share on Twitter';
        public $shareOnLinkedIn = 'Share on LinkedIn';
        public $shareOnGooglePlus = 'Share on Google+';
		public $shareOnFacebook = 'Share on Facebook';
        public $comment = 'Comment or like !';
        public $showComments = 'Show comments';
        public $by = 'by';
        public $datePrefix = '';
        public $secondsAgo = ' seconds ago';
        public $minuteAgo = ' minute ago';
        public $minutesAgo = ' minutes ago';
        public $hourAgo = ' hour ago';
        public $hoursAgo = ' hours ago';
        public $dayAgo = ' day ago';
        public $daysAgo = ' days ago';
        public $weekAgo = ' week ago';
        public $weeksAgo = ' weeks ago';

        /**
         * @param string $title
         */
        public function setTitle($title)
        {
            $this->title = $title;
        }

        /**
         * @return string
         */
        public function getTitle()
        {
            return $this->title;
        }

        /**
         * @param string $by
         */
        public function setBy($by)
        {
            $this->by = $by;
        }

        /**
         * @return string
         */
        public function getBy()
        {
            return $this->by;
        }

        /**
         * @param string $comment
         */
        public function setComment($comment)
        {
            $this->comment = $comment;
        }

        /**
         * @return string
         */
        public function getComment()
        {
            return $this->comment;
        }

        /**
         * @param string $datePrefix
         */
        public function setDatePrefix($datePrefix)
        {
            $this->datePrefix = $datePrefix;
        }

        /**
         * @return string
         */
        public function getDatePrefix()
        {
            return $this->datePrefix;
        }

        /**
         * @param string $dayAgo
         */
        public function setDayAgo($dayAgo)
        {
            $this->dayAgo = $dayAgo;
        }

        /**
         * @return string
         */
        public function getDayAgo()
        {
            return $this->dayAgo;
        }

        /**
         * @param string $daysAgo
         */
        public function setDaysAgo($daysAgo)
        {
            $this->daysAgo = $daysAgo;
        }

        /**
         * @return string
         */
        public function getDaysAgo()
        {
            return $this->daysAgo;
        }

        /**
         * @param string $hourAgo
         */
        public function setHourAgo($hourAgo)
        {
            $this->hourAgo = $hourAgo;
        }

        /**
         * @return string
         */
        public function getHourAgo()
        {
            return $this->hourAgo;
        }

        /**
         * @param string $hoursAgo
         */
        public function setHoursAgo($hoursAgo)
        {
            $this->hoursAgo = $hoursAgo;
        }

        /**
         * @return string
         */
        public function getHoursAgo()
        {
            return $this->hoursAgo;
        }

        /**
         * @param string $minuteAgo
         */
        public function setMinuteAgo($minuteAgo)
        {
            $this->minuteAgo = $minuteAgo;
        }

        /**
         * @return string
         */
        public function getMinuteAgo()
        {
            return $this->minuteAgo;
        }

        /**
         * @param string $minutesAgo
         */
        public function setMinutesAgo($minutesAgo)
        {
            $this->minutesAgo = $minutesAgo;
        }

        /**
         * @return string
         */
        public function getMinutesAgo()
        {
            return $this->minutesAgo;
        }

        /**
         * @param string $secondsAgo
         */
        public function setSecondsAgo($secondsAgo)
        {
            $this->secondsAgo = $secondsAgo;
        }

        /**
         * @return string
         */
        public function getSecondsAgo()
        {
            return $this->secondsAgo;
        }

        /**
         * @param string $shareOnFacebook
         */
        public function setShareOnFacebook($shareOnFacebook)
        {
            $this->shareOnFacebook = $shareOnFacebook;
        }

        /**
         * @return string
         */
        public function getShareOnFacebook()
        {
            return $this->shareOnFacebook;
        }

        /**
         * @param string $shareOnGooglePlus
         */
        public function setShareOnGooglePlus($shareOnGooglePlus)
        {
            $this->shareOnGooglePlus = $shareOnGooglePlus;
        }

        /**
         * @return string
         */
        public function getShareOnGooglePlus()
        {
            return $this->shareOnGooglePlus;
        }

        /**
         * @param string $shareOnLinkedIn
         */
        public function setShareOnLinkedIn($shareOnLinkedIn)
        {
            $this->shareOnLinkedIn = $shareOnLinkedIn;
        }

        /**
         * @return string
         */
        public function getShareOnLinkedIn()
        {
            return $this->shareOnLinkedIn;
        }

        /**
         * @param string $shareOnTwitter
         */
        public function setShareOnTwitter($shareOnTwitter)
        {
            $this->shareOnTwitter = $shareOnTwitter;
        }

        /**
         * @return string
         */
        public function getShareOnTwitter()
        {
            return $this->shareOnTwitter;
        }

        /**
         * @param string $showComments
         */
        public function setShowComments($showComments)
        {
            $this->showComments = $showComments;
        }

        /**
         * @return string
         */
        public function getShowComments()
        {
            return $this->showComments;
        }

        /**
         * @param string $weekAgo
         */
        public function setWeekAgo($weekAgo)
        {
            $this->weekAgo = $weekAgo;
        }

        /**
         * @return string
         */
        public function getWeekAgo()
        {
            return $this->weekAgo;
        }

        /**
         * @param string $weeksAgo
         */
        public function setWeeksAgo($weeksAgo)
        {
            $this->weeksAgo = $weeksAgo;
        }

        /**
         * @return string
         */
        public function getWeeksAgo()
        {
            return $this->weeksAgo;
        }


    }
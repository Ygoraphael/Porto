<?php
    namespace seoFacebookTimeline;
    class facebookComment {
        protected $userId;
        protected $name;
        protected $likeCount = 0;
        /** @var \DateTime */
        protected $createdAt;
        protected $message;
        /** @var \seoFacebookTimeline\facebookComment[] */
        protected $comments = array();
        protected $commentsCount = 0;
        /** @var \seoFacebookTimeline\timeline */
        private $timeline;

        /**
         * facebookComment constructor.
         * @param timeline $timeline
         */
        public function __construct(\seoFacebookTimeline\timeline $timeline)
        {
            $this->timeline = $timeline;
        }


        /**
         * Load the data
         */
        public function load($comment){
            if(!empty($comment['like_count'])) {
                $this->setLikeCount($comment['like_count']);
            }
            $this->setCreatedAt(new \DateTime($comment['created_time']));
            $this->setUserId($comment['from']['id']);
            $this->setName($comment['from']['name']);
            $this->setMessage($comment['message']);

            # Subcomments
            if(isset($comment['comments']['data'])){
                $comments = $comment['comments']['data'];
                rsort($comments);
                foreach($comments as $subcomment) {
                    if (!isset($subcomment['message'])) {
                        continue;
                    }
                    $fbComment = new facebookComment($this->timeline);
                    $fbComment->load($subcomment);
                    $this->comments[] = $fbComment;
                }
                if(count($this->comments) <= $this->timeline->getMaxComments()-1){
                    $this->setCommentsCount(count($this->comments));
                }else{
                    $this->setCommentsCount($comment['comments']['summary']['total_count']);
                }
            }
        }

        /**
         * @param \DateTime $createdAt
         */
        public function setCreatedAt($createdAt)
        {
            $this->createdAt = $createdAt;
        }

        /**
         * @return \DateTime
         */
        public function getCreatedAt()
        {
            return $this->createdAt;
        }

        /**
         * @param int $likeCount
         */
        public function setLikeCount($likeCount)
        {
            $this->likeCount = $likeCount;
        }

        /**
         * @return int
         */
        public function getLikeCount()
        {
            return $this->likeCount;
        }

        /**
         * @param mixed $message
         */
        public function setMessage($message)
        {
            $this->message = $message;
        }

        /**
         * @return mixed
         */
        public function getMessage()
        {
            return $this->message;
        }

        /**
         * @param mixed $name
         */
        public function setName($name)
        {
            $this->name = $name;
        }

        /**
         * @return mixed
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param mixed $userId
         */
        public function setUserId($userId)
        {
            $this->userId = $userId;
        }

        /**
         * @return mixed
         */
        public function getUserId()
        {
            return $this->userId;
        }

        /**
         * @param int $commentsCount
         */
        public function setCommentsCount($commentsCount)
        {
            $this->commentsCount = $commentsCount;
        }

        /**
         * @return int
         */
        public function getCommentsCount()
        {
            return $this->commentsCount;
        }

        /**
         * @return \seoFacebookTimeline\facebookComment[]
         */
        public function getComments()
        {
            return $this->comments;
        }
    }
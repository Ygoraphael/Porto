<?php
    namespace seoFacebookTimeline;
    use \seoFacebookTimeline\facebookComment;

    class facebookItem {
        protected $id;
        protected $name;
        protected $content;
        /** @var \DateTime */
        protected $createdAt = null;
		protected $createdPublished = null;
        protected $video;
		protected $mp4video;
		protected $soundcloud;
        protected $image;
		protected $type;
        /** @var \seoFacebookTimeline\timeline */
        private $timeline;
        protected $sharedStory = false;
        protected $sharedStoryName;
        protected $sharedStoryLink;
        protected $sharedStoryCaption;
        protected $sharedStoryDescription;
        /** @var \seoFacebookTimeline\facebookComment[] */
        protected $comments = array();
        protected $commentsCount = 0;
        protected $likesCount = 0;
        protected $shareURL = false;

        public function __construct(\seoFacebookTimeline\timeline $timeline){
            $this->timeline = $timeline;
        }

        /**
         * Load the data
         */
        public function load($data){
            # Id
            $ids = explode('_',$data['id']);
            $this->setId($ids[1]);

            # Content
			if(isset($data['message'])){
                $this->setContent($data['message']);
            }elseif(isset($data['caption'])){
                $this->setContent($data['caption']);
            }elseif(isset($data['story'])){
                $this->setContent($data['story']);
            }else{
                return false;
            }

            # Name
            $this->setName(isset($data['name']) ? $data['name'] : preg_replace('/\r|\n/','', substr($this->getContent(), 0, 70)));

            # Created at
            if($data['created_time'] != ''){
            $this->setCreatedAt(new \DateTime($data['created_time']));
			$this->setCreatedPublished($data['created_time']);
            }

            if($data['type'] != ''){
            	$this->setType($data['type']);
                if(isset($data['link'])){
				$this->setSharedStoryLink($data['link']);
			}
			}

            # Share URL
            $this->setShareURL('https://www.facebook.com/'.$this->timeline->getUsername().'/posts/'.$this->getId());

            # Youtube
            if($data['type'] == 'video' && stripos($data['source'], 'youtu')){
                $this->setVideo(embedYoutube($data['source']));
            }

            # Soundcloud
            if($data['type'] == 'video' && stripos($data['source'], 'soundcloud')){
                $this->setSoundcloud(embedSoundcloud($data['source']));
            }

            # Image
            if(isset($data['full_picture']) && $this->timeline->getShowImages()){
                if($this->timeline->getHrImages() && !isset($data['object_id'])){
                    $pictures = $data['full_picture'];
                    $bigjpg = '_s.jpg%';
                    $bigpng = '_s.png%';
                    $biggif = '_s.gif%';
                    $bigbmp = '_s.bmp%';
                    $imagecheck1 = stripos($pictures, $bigjpg);
                    $imagecheck2 = stripos($pictures, $bigpng);
                    $imagecheck3 = stripos($pictures, $biggif);
                    $imagecheck4 = stripos($pictures, $bigbmp);
                    if ( !($imagecheck1 || $imagecheck2 || $imagecheck3 || $imagecheck4) ) {
                        //Show larger image
                        $pictures = str_replace('_s.','_b.',$pictures);
                        $pictures = str_replace('_q.','_b.',$pictures);
                        $pictures = str_replace('_t.','_b.',$pictures);
                    }
                }else if ($this->timeline->getHrImages() && isset($data['object_id'])) {
                    $pictures = 'https://graph.facebook.com/'.$data['object_id'].'/picture?width=9999&height=9999';
                }else {
                    $pictures = $data['picture'];
                }
                //Hack to get highres image
				$pictures = str_replace(array('','%2Fs100x100','%2Fs200x200',''),array('','','','') , $pictures);
                $this->setImage('<img itemprop="image" data-src="'.$pictures.'" src="'.$data['picture'].'" alt="'.$this->timeline->escape($this->getName()).'">');
            }

			# MP4 video
			if($data['type'] == 'video' && stripos($data['source'], '.mp4') && isset($data['object_id'])) {

				//highres video thumb mp4
				//if ($this->timeline->getHrImages() && isset($data['attachments']['data']['0']['media']['image']['src'])) {
				//		$videopicture = $data['attachments']['data']['0']['media']['image']['src'];
				//	}else{
				//		$videopicture = $data['picture'];
				//}

                //$this->setMP4Video('<video poster="' . $videopicture . '" controls="controls">
				//					<source src="' . $data['source'] . '" type="video/mp4">
				//					Your browser does not support playing an mp4.
				//					</video>');
				$this->setMP4Video('<iframe src="https://www.facebook.com/plugins/video.php?href=' . $data['link'] . '&width=500&show_text=false&height=280" width="500" height="280" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>');
			}

            # Shared story
            if (isset($data['status_type']) && strpos($data['status_type'],'shared_story') !== false) {
                $this->setSharedStory(true);
                if (isset($data['link'])) {
                    $name = $this->getName();
                    if ($name == '' && isset($data['story'])) {
                        $name = $data['story'];
                    }
                    $this->setSharedStoryLink($data['link']);
                    $this->setSharedStoryName($name);
                    $this->setSharedStoryCaption(isset($data['caption']) ? $data['caption'] : null);
                }

                if (isset($data['description'])) {
                    $this->setSharedStoryDescription($data['description']);
                }
            }

			# Likes
            if(!empty($data['likes'])){
                $this->setLikesCount($data['likes']['summary']['total_count']);
            }

            # Comments
            if($this->timeline->getShowComments() && isset($data['comments']['data'])){
                $comments = $data['comments']['data'];
                rsort($comments);
                foreach($comments as $comment) {
                    if (!isset($comment['message'])) {
                        continue;
                    }
                    $fbComment = new facebookComment($this->timeline);
                    $fbComment->load($comment);
                    $this->comments[] = $fbComment;
                }
				if(count($this->comments) <= $this->timeline->getMaxComments()-1){
                	$this->setCommentsCount(count($this->comments));
				}else{
                	$this->setCommentsCount($data['comments']['summary']['total_count']);
                }
            }
		}

        /**
         * @param boolean $shareURL
         */
        public function setShareURL($shareURL)
        {
            $this->shareURL = $shareURL;
        }

        /**
         * @return boolean
         */
        public function getShareURL()
        {
            return $this->shareURL;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $type
         */
        public function setType($type)
        {
            $this->type = $type;
        }

        /**
         * @return mixed
         */
        public function getType()
        {
            return $this->type;
        }

        /**
         * @param int $likesCount
         */
        public function setLikesCount($likesCount)
        {
            $this->likesCount = $likesCount;
        }

        /**
         * @return int
         */
        public function getLikesCount()
        {
            return $this->likesCount;
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
         * @param mixed $content
         */
        public function setContent($content)
        {
            $this->content = $content;
        }

        /**
         * @return mixed
         */
        public function getContent()
        {
            return $this->content;
        }

        /**
         * @param mixed $createdAt
         */
        public function setCreatedAt($createdAt)
        {
            $this->createdAt = $createdAt;
        }

        /**
         * @return mixed
         */
        public function getCreatedAt()
        {
            return $this->createdAt;
        }

        /**
         * @param mixed $createdPublished
         */
        public function setCreatedPublished($createdPublished)
        {
            $this->createdPublished = $createdPublished;
        }

        /**
         * @return mixed
         */
        public function getCreatedPublished()
        {
            return $this->createdPublished;
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
         * @return mixed
         */
        public function getVideo()
        {
            return $this->video;
        }

        /**
         * @param mixed $video
         */
        public function setVideo($video)
        {
            $this->video = $video;
        }

        /**
         * @return mixed
         */
        public function getMP4Video()
        {
            return $this->mp4video;
        }

        /**
         * @param mixed $mp4video
         */
        public function setMP4Video($mp4video)
        {
            $this->mp4video = $mp4video;
        }

        /**
         * @return mixed
         */
        public function getSoundcloud()
        {
            return $this->soundcloud;
        }

        /**
         * @param mixed $soundcloud
         */
        public function setSoundcloud($soundcloud)
        {
            $this->soundcloud = $soundcloud;
        }

        /**
         * @param mixed $image
         */
        public function setImage($image)
        {
            $this->image = $image;
        }

        /**
         * @return mixed
         */
        public function getImage()
        {
            return $this->image;
        }

        /**
         * @param boolean $sharedStory
         */
        public function setSharedStory($sharedStory)
        {
            $this->sharedStory = $sharedStory;
        }

        /**
         * @return boolean
         */
        public function getSharedStory()
        {
            return $this->sharedStory;
        }

        /**
         * @param mixed $sharedStoryCaption
         */
        public function setSharedStoryCaption($sharedStoryCaption)
        {
            $this->sharedStoryCaption = $sharedStoryCaption;
        }

        /**
         * @return mixed
         */
        public function getSharedStoryCaption()
        {
            return $this->sharedStoryCaption;
        }

        /**
         * @param mixed $sharedStoryLink
         */
        public function setSharedStoryLink($sharedStoryLink)
        {
            $this->sharedStoryLink = $sharedStoryLink;
        }

        /**
         * @return mixed
         */
        public function getSharedStoryLink()
        {
            return $this->sharedStoryLink;
        }

        /**
         * @param mixed $sharedStoryName
         */
        public function setSharedStoryName($sharedStoryName)
        {
            $this->sharedStoryName = $sharedStoryName;
        }

        /**
         * @return mixed
         */
        public function getSharedStoryName()
        {
            return $this->sharedStoryName;
        }

        /**
         * @param mixed $sharedStoryDescription
         */
        public function setSharedStoryDescription($sharedStoryDescription)
        {
            $this->sharedStoryDescription = $sharedStoryDescription;
        }

        /**
         * @return mixed
         */
        public function getSharedStoryDescription()
        {
            return $this->sharedStoryDescription;
        }

        /**
         * @return \seoFacebookTimeline\facebookComment[]
         */
        public function getComments()
        {
            return $this->comments;
        }


    }
<?php
require_once("ProfileData.php");
class ProfileGenerator {

    private $con, $userLoggedInObj, $profileData;

    public function __construct($con, $userLoggedInObj, $profileUsername) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
        $this->profileData = new ProfileData($con, $profileUsername);
    } // End of Constructor

    public function create() {
        $profileUsername = $this->profileData->getProfileUsername();
        
        if(!$this->profileData->userExists()) {
            return "User does not exist";
    	}

    	$coverPhotoSection = $this->createCoverPhotoSection();
        $headerSection = $this->createHeaderSection();
        $tabsSection = $this->createTabsSection();
        $contentSection = $this->createContentSection();
        return "<div class='profileContainer'>
                    $coverPhotoSection
                    $headerSection
                    $tabsSection
                    $contentSection
                </div>";
    } // End of public function create

    public function createCoverPhotoSection() {
        $coverPhotoSrc = $this->profileData->getCoverPhoto();
        $name = $this->profileData->getProfileUserFullName();
        return "<div class='coverPhotoContainer'>
                	<span class='channelName'>$name</span>
                    <img src='$coverPhotoSrc' class='coverPhoto'>
                </div>";
    } // End of public function createCoverPhotoSection

    public function createHeaderSection() {
    	$profileImage = $this->profileData->getProfilePic();
    	$name = $this->profileData->getProfileUserFullName();
    	$subCount = $this->profileData->getSubscriberCount();

    	$button = $this->createHeaderButton();

    	return "<div class='profileHeader'>
    				<div class='userInfoContainer'>
    					<img class='profileImage' src='$profileImage'>
    					<div class='userInfo'>
    						<span class='title'>$name</span>
    						<span class='subscriberCount'>$subCount subscribers</span>
    					</div>
    				</div>
    				<div class='buttonContainer'>
    					<div class='buttonItem'>
    						$button
    					</div>
    				</div>
    			</div>";
    	
    } // End of public function createHeaderSection

    public function createTabsSection() {
    	return "<ul class='nav nav-tabs' role='tablist'>
				  <li class='nav-item'>
				    <a class='nav-link active' id='videos-tab' data-toggle='tab' href='#videos' role='tab' aria-controls='videos' aria-selected='true'>VIDEOS</a>
				  </li>
				  <li class='nav-item'>
				    <a class='nav-link' id='about-tab' data-toggle='tab' href='#about' role='tab' aria-controls='about' aria-selected='false'>ABOUT</a>
				  </li>
				</ul>";
    } // End of public function createTabsSection

    public function createContentSection() {

    	$videos = $this->profileData->getusersVideos();

    	if(sizeof($videos) > 0) {
    		$videoGrid = new VideoGrid($this->con, $this->userLoggedInObj);
    		$videoGridHtml = $videoGrid->create($videos, null, false);
    	}
    	else {
    		$videoGridHtml = "<span>This user has no videos</span>";
    	}

    	$aboutSection = $this->createAboutSection();

    	return "<div class='tab-content channelContent'>
				  <div class='tab-pane fade show active' id='videos' role='tabpanel' aria-labelledby='videos-tab'>
					$videoGridHtml
				  </div>
				  <div class='tab-pane fade' id='about' role='tabpanel' aria-labelledby='about-tab'>
				  	$aboutSection
				  </div>";
    } // End of public function createContentSection

    private function createHeaderButton() {
    	if($this->userLoggedInObj->getUsername() == $this->profileData->getProfileUsername()) {
    		return "";
    	}
    	else
    		return ButtonProvider::createSubscriberButton($this->con, $this->profileData->getProfileUserObj(), $this->userLoggedInObj);
    } // End of public function createHeaderButton

    private function createAboutSection() {
    	$html = "<div class='section'>
    				<div class='title'>
    					<span>Details</span>
    				</div>
    				<div class='values'>";

    	$details = $this->profileData->getAllUserDetails();
    	foreach($details as $key => $value) {
    		$html .= "<span>$key: $value</span>";
    	}

    	$html .= "</div></div>";

    	return $html;
    } // End of private function createAboutSection











} // End of class ProfileGenerator
?>
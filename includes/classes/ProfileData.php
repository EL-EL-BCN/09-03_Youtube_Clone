<?php
class ProfileData {
    
    private $con, $profileUserObj;

    public function __construct($con, $profileUsername) {
        $this->con = $con;
        $this->profileUserObj = new User($con, $profileUsername);
    } // End of Constructor

    public function getProfileUserObj() {
    	return $this->profileUserObj;
    } // End of public function getProfileUserObj

    public function getProfileUsername() {
        return $this->profileUserObj->getUsername();
    } // End of public function create

    public function userExists() {
        $query = $this->con->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindParam(":username", $profileUsername);
        $profileUsername = $this->getProfileUsername();
        $query->execute();

        return $query->rowCount() != 0;
    } // End of public function UserExists

    public function getCoverPhoto() {
        return "assets/images/coverPhotos/default-cover-photo.jpg";
    } // End of public function GetProfilePic

    public function getProfileUserFullName() {
        return $this->profileUserObj->getName();
    } // End of public function getUsersFullName

    public function getProfilePic() {
    	return $this->profileUserObj->getProfilePic();
    } // End of public function getProfilePic

    public function getSubscriberCount() {
        return $this->profileUserObj->getSubscriberCount();
    } // End of public function getSubscriberCount

    public function getusersVideos() {
    	$query = $this->con->prepare("SELECT * FROM videos WHERE uploadedBy=:uploadedBy ORDER BY uploadDate DESC");
    	$query->bindParam(":uploadedBy", $username);
    	$username = $this->getProfileUsername();
    	$query->execute();

    	$videos = array();
    	while($row = $query->fetch(PDO::FETCH_ASSOC)) {
    		$videos[] = new Video($this->con, $row, $this->profileUserObj->getUsername());
    	}
    	return $videos;
    } // End of public function getusersVideos

    private function getTotalViews() {
    	$query = $this->con->prepare("SELECT sum(views) FROM videos WHERE uploadedBy=:uploadedBy");
    	$query->bindParam(":uploadedBy", $username);
    	$username = $this->getProfileUsername();
    	$query->execute();

    	return $query->fetchColumn();
    } // End of private function getTotalViews

    private function getSignUpDate() {
    	$date = $this->profileUserObj->getSignUpDate();
    	return date("F jS, Y", strtotime($date));
    } // End of private function getSignUpDate

    public function getAllUserDetails() {
    	return array(
    		"name" => $this->getProfileUserFullName(),
    		"Username" => $this->getProfileUsername(),
    		"subscribers" => $this->getSubscriberCount(),
    		"Total views" => $this->getTotalViews(),
    		"Sign up Date" => $this->getSignUpDate()
    	);
    } // End of public function getAllUserDetails


} // End of class ProfileData
?>
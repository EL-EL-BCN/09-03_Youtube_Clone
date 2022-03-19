<?php
class VideoUploadData {

	Public $videoDataArray, $title, $description, $privacy, $category, $uploadedBy;

	public function __construct($videoDataArray, $title, $description, $privacy, $category, $uploadedBy) {
		$this->videoDataArray = $videoDataArray;
		$this->title = $title;
		$this->description = $description;
		$this->privacy = $privacy;
		$this->category = $category;		
		$this->uploadedBy = $uploadedBy;
	} // End of class constructor

	public function updateDetails($con, $videoId) {
		$query = $con->prepare("UPDATE videos SET title=:title, description=:description, privacy=:privacy, category=:category WHERE id=:videoId");
		$query->bindParam(":title", $this->title);
		$query->bindParam(":description", $this->description);
		$query->bindParam(":privacy", $this->privacy);
		$query->bindParam(":category", $this->category);
		$query->bindParam(":videoId", $videoId);

		return $query->execute();
	} // End of public function updateDetails

} // End of class VideoUploadData
?>
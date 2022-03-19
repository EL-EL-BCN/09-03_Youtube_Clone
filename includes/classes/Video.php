<?php

class Video {

    private $con, $sqlData, $userLoggedInObj;

    public function __construct($con, $input, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

        if(is_array($input)) {
            $this->sqlData = $input;
        }
        else {
            $query = $this->con->prepare("SELECT * FROM videos WHERE id = :id");
            $query->bindParam(":id", $input);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }
	} // End of constructor

	public function getId() {
		return $this->sqlData["id"];
	} // End of public function getId

	public function getUploadedBy() {
		return $this->sqlData["uploadedBy"];
	} // End of public function getUploadedBy

	public function getTitle() {
		return $this->sqlData["title"];
	} // End of public function getTitle

	public function getDescription() {
		return $this->sqlData["description"];
	} // End of public function getDescription

	public function getPrivacy() {
		return $this->sqlData["privacy"];
	} // End of public function getDescription

	public function getFilePath() {
		return $this->sqlData["filePath"];
	} // End of public function getDescription

	public function getCategory() {
		return $this->sqlData["category"];
	} // End of public function getCategory

	public function getUploadDate() {
		$date = $this->sqlData["uploadDate"];
		return date("M j, Y", strtotime($date));
	} // End of public function getUploadedDate

    public function getTimestamp() {
        $date = $this->sqlData["uploadDate"];
        return date("M jS, Y", strtotime($date));
    } // End of public function getUploadedDate

	public function getViews() {
		return $this->sqlData["views"];
	} // End of public function getViews

	public function getDuration() {
		return $this->sqlData["duration"];
	} // End of public function getDuration

	public function incrementViews() {
        $query = $this->con->prepare("UPDATE videos SET views=views+1 WHERE id=:id");
        $query->bindParam(":id", $videoId);

        $videoId = $this->getId();
        $query->execute();

        $this->sqlData["views"] = $this->sqlData["views"] + 1;
	} // End of public function incrementViews

	public function getLikes() {
        $query = $this->con->prepare("SELECT count(*) as 'count' FROM likes WHERE videoId = :videoId");
        $query->bindParam(":videoId", $videoId);
        $videoId = $this->getId();
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data["count"];
    } // End of public function getLikes

    public function getDislikes() {
        $query = $this->con->prepare("SELECT count(*) as 'count' FROM dislikes WHERE videoId = :videoId");
        $query->bindParam(":videoId", $videoId);
        $videoId = $this->getId();
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data["count"];
    } // End of public function getDislikes

    public function like() {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        if($this->wasLikedBy()) {
            // User has already liked
            $query = $this->con->prepare("DELETE FROM likes WHERE username=:username AND videoId=:videoId");
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();

            $result = array(
                "likes" => -1,
                "dislikes" => 0
            );
            return json_encode($result);
        }
        else {
            $query = $this->con->prepare("DELETE FROM dislikes WHERE username=:username AND videoId=:videoId");
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();
            $count = $query->rowCount();

            $query = $this->con->prepare("INSERT INTO likes(username, videoId) VALUES(:username, :videoId)");
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();

            $result = array(
                "likes" => 1,
                "dislikes" => 0 - $count
            );
            return json_encode($result);
        }
    } // End of public function like

    public function dislike() {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        if($this->wasDislikedBy()) {
            // User has already liked
            $query = $this->con->prepare("DELETE FROM dislikes WHERE username=:username AND videoId=:videoId");
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();

            $result = array(
                "likes" => 0,
                "dislikes" => -1
            );
            return json_encode($result);
        }
        else {
            $query = $this->con->prepare("DELETE FROM likes WHERE username=:username AND videoId=:videoId");
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();
            $count = $query->rowCount();

            $query = $this->con->prepare("INSERT INTO dislikes(username, videoId) VALUES(:username, :videoId)");
            $query->bindParam(":username", $username);
            $query->bindParam(":videoId", $id);
            $query->execute();

            $result = array(
                "likes" => 0 - $count,
                "dislikes" => 1
            );
            return json_encode($result);
        }
    } // End of public function dislike

    public function wasLikedBy() {
        $query = $this->con->prepare("SELECT * FROM likes WHERE username=:username AND videoId=:videoId");
        $query->bindParam(":username", $username);
        $query->bindParam(":videoId", $id);

        $id = $this->getId();

        $username = $this->userLoggedInObj->getUsername();
        $query->execute();

        return $query->rowCount() > 0;
    } // End of public function wasLikedBy

    public function wasDislikedBy() {
        $query = $this->con->prepare("SELECT * FROM dislikes WHERE username=:username AND videoId=:videoId");
        $query->bindParam(":username", $username);
        $query->bindParam(":videoId", $id);

        $id = $this->getId();

        $username = $this->userLoggedInObj->getUsername();
        $query->execute();

        return $query->rowCount() > 0;
    } // End of public function wasDislikedBy

    public function getNumberOfComments() {
    	$query = $this->con->prepare("SELECT * FROM comments WHERE videoId=:videoId");
    	$query->bindParam(":videoId", $id);
    	$id = $this->getId();
    	$query->execute();
    	return $query->rowCount();
    } // end of public function getNumberOfComments

    public function getComments() {
        $query = $this->con->prepare("SELECT * FROM comments WHERE videoId=:videoId AND responseTo=0 ORDER BY datePosted DESC");
        $query->bindParam(":videoId", $id);
        $id = $this->getId();
        $query->execute();

        $comments = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $comment = new Comment($this->con, $row, $this->userLoggedInObj, $id);
            array_push($comments, $comment);
        }
        return $comments;
    } // End of public function getComments

    public function getThumbnail() {
        $query = $this->con->prepare("SELECT filePath FROM thumbnails WHERE videoId=:videoId AND selected=1");
        $query->bindParam(":videoId", $videoId);
        $videoId = $this->getId();
        $query->execute();

        return $query->fetchColumn();
    } // End of public function getThumbnail



} // End of class Video
?>
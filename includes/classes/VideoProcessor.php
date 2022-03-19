<?php 
class VideoProcessor {

	private $con;
	private $sizeLimit = 500000000;
	private $allowedTypes = array("mp4", "flv", "webm", "mkv", "vob", "ogg", "avi", "wmv", "mov", "mpeg", "mpg");
	private $ffmpegPath;
	private $ffprobePath;

	public function __construct($con) {
		$this->con = $con;
		$this->ffmpegPath = realpath("ffmpeg/bin/ffmpeg.exe");
		$this->ffprobePath = realpath("ffmpeg/bin/ffprobe.exe");
	} // end of constructor

	public function upload($videoUploadData) {
		
		$targetDir = "uploads/videos/";
		$videoData = $videoUploadData->videoDataArray;

		$tempFilePath = $targetDir . uniqid() . basename($videoData["name"]);
		$tempFilePath = str_replace(" ", "_", $tempFilePath);

		$isValidData = $this->processData($videoData, $tempFilePath);

		if(!$isValidData) {
			return false;
		}

		if(move_uploaded_file($videoData["tmp_name"], $tempFilePath)) {
			

			$finalFilePath = $targetDir . uniqid() . ".mp4";

			If(!$this->insertVideoData($videoUploadData, $finalFilePath)) {
				echo "insert Query Failed";
				return false;
			}

			if(!$this->convertVideoToMp4($tempFilePath, $finalFilePath)) {
				echo "upload failed";
				return false;
			}

			if(!$this->deleteFile($tempFilePath)) {
				echo "upload failed\n";
				return false;
			}

			if(!$this->generateThumbnails($finalFilePath)) {
				echo "upload failed - could not generate thumbnails\n";
				return false;
			}
			
			return true;
		}
				
	} // end of public function upload

	private function processData($videoData, $filePath) {
		$videoType = pathInfo($filePath, PATHINFO_EXTENSION);

		if(!$this->isValidSize($videoData)) {
			echo "file too large. Cannot be more than " . $this->sizeLimit . " bytes";
			return false;
		}
		else if(!$this->isValidType($videoType)) {
			echo "Invalid file type";
			return false;
		}
		else if($this->hasError($videoData)) {
			echo "Error Code: " .$videoData["error"];
			return false;
		}

		return true;

	} // end of Private function processData

    private function isValidSize($data) {
        return $data["size"] <= $this->sizeLimit;
    } // End of private function isValidSize

    private function isValidType($type) {
        $lowercased = strtolower($type);
        return in_array($lowercased, $this->allowedTypes);
    } // End of private function isValidType
    
    private function hasError($data) {
        return $data["error"] != 0;
    } // End of private function hasError

    private function insertVideoData($uploadData, $filePath) {
        $query = $this->con->prepare("INSERT INTO videos(title, uploadedBy, description, privacy, category, filePath)
                                        VALUES(:title, :uploadedBy, :description, :privacy, :category, :filePath)");

        $query->bindParam(":title", $uploadData->title);
        $query->bindParam(":uploadedBy", $uploadData->uploadedBy);
        $query->bindParam(":description", $uploadData->description);
        $query->bindParam(":privacy", $uploadData->privacy);
        $query->bindParam(":category", $uploadData->category);
        $query->bindParam(":filePath", $filePath);

        return $query->execute();
    
	} // end of private function insertVideoData

	public function convertVideoToMp4($tempFilePath, $finalFilePath) {
		$cmd = "$this->ffmpegPath -i $tempFilePath $finalFilePath 2>&1";

		$outputLog = array();

		exec($cmd, $outputLog, $returnCode);

		if($returnCode != 0) {
			// command failed
			foreach($outputLog as $line) {
				echo $line . "<br>";
			}
			return false;
		}
		return true;
	}

	private function deleteFile($filePath) {
		if(!unlink($filePath)) {
			echo "Could not delete file\n";
			return false;
		}
		return true;
	} // End of private function deleteFile

	public function generateThumbnails($filePath) {

		$thumbnailSize = "210x118";
		$numThumbnails = 3;
		$pathToThumbnail = "uploads/videos/thumbnails";

		$duration = $this->getVideoDuration($filePath);

		$videoId = $this->con->lastInsertId();
		$this->updateDuration($duration, $videoId);

		for($num = 1; $num <= $numThumbnails; $num++) {
			$immageName = uniqid() . ".jpg";
			$interval = ($duration * 0.8) / $numThumbnails * $num;
			$fullThumbnailPath = "$pathToThumbnail/$videoId-$immageName";

			$cmd = "$this->ffmpegPath -i $filePath -ss $interval -s $thumbnailSize -vframes 1 $fullThumbnailPath 2>&1";

			$outputLog = array();

			exec($cmd, $outputLog, $returnCode);

			if($returnCode != 0) {
				// command failed
				foreach($outputLog as $line) {
					echo $line . "<br>";
				}
			}

			$query = $this->con->prepare("INSERT INTO thumbnails(videoId, FilePath, selected) VALUES(:videoId, :filePath, :selected)");
			$query->bindParam(":videoId", $videoId);
			$query->bindParam(":filePath", $fullThumbnailPath);
			$query->bindParam(":selected", $selected);

			$selected = $num == 1 ? 1 : 0;

			$success = $query->execute();

			if(!$success) {
				echo "Error inserting thumbnail\n";
				return false;
			}
		}
		return true;

	} // end of public function generateThumbnails

	private function getVideoDuration($filePath) {
		return (int)shell_exec("$this->ffprobePath -v error -select_streams v:0 -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");
	} // End of private function getVideoDuration

	private function updateDuration($duration, $videoId) {
        $hours = floor($duration / 3600);
        $mins = floor(($duration - ($hours*3600)) / 60);
        $secs = floor($duration % 60);
        
        $hours = ($hours < 1) ? "" : $hours . ":";
        $mins = ($mins < 10) ? "0" . $mins . ":" : $mins . ":";
        $secs = ($secs < 10) ? "0" . $secs : $secs;

        $duration = $hours.$mins.$secs;

        $query = $this->con->prepare("UPDATE videos SET duration=:duration WHERE id=:videoId");
        $query->bindParam(":duration", $duration);
        $query->bindParam(":videoId", $videoId);
        $query->execute();
    } // End of private function updateDuration







}
?>
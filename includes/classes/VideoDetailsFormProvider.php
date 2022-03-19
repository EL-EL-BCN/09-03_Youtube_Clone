<?php
class VideoDetailsFormProvider {

	private $con;

	public function __construct($con) {
		$this->con = $con;
	} // End of class constructor

    public function createUploadForm() {
        $fileInput = $this->createFileInput(null);
        $titleInput = $this->createTitleInput(null);
        $descriptionInput = $this->createDescriptionInput(null);
        $privacyInput = $this->createPrivacyInput(null);
        $categoriesInput = $this->CreateCategoriesInput(null);
        $uploadButton = $this->createUploadButton();
        return "<form action='processing.php' method='POST' enctype='multipart/form-data'>
                    $fileInput
                    $titleInput
                    $descriptionInput
                    $privacyInput
                    $categoriesInput
                    $uploadButton
                </form>";
    } // End of public function createUploadForm

    public function createEditDetailsForm($video) {
        $titleInput = $this->createTitleInput($video->getTitle());
        $descriptionInput = $this->createDescriptionInput($video->getDescription());
        $privacyInput = $this->createPrivacyInput($video->getPrivacy());
        $categoriesInput = $this->CreateCategoriesInput($video->getCategory());
        $saveButton = $this->createSaveButton();
        return "<form method='POST'>
                    $titleInput
                    $descriptionInput
                    $privacyInput
                    $categoriesInput
                    $saveButton
                </form>";
    } // End of public function createEditDetailsForm

    private function createSaveButton() {
        return "<button type='submit' class='btn btn-primary' name='saveButton'>Save</button>";
    } // End of private function createUploadButton

    private function createFileInput() {
        return "<div class='form-group'>
                    <label for='exampleFormControlFile1'>Your file</label>
                    <input type='file' class='form-control-file' id='exampleFormControlFile1' name='fileInput' required>
                </div>";
    } // End of private function createFileInput

    private function createTitleInput($value) {
        if($value == null) $value ="";
        return "<div class='form-group'>
                    <input class='form-control' type='text' placeholder='Title' name='titleInput' value='$value'>
                </div>";
    } // End of private function createTitleInput

    private function createDescriptionInput($value) {
        if($value == null) $value ="";
        return "<div class='form-group'>
                    <textarea class='form-control' placeholder='Description' name='descriptionInput' rows='3'>$value</textarea>
                </div>";
    } // End of private function createDescriptionInput

    private function createPrivacyInput($value) {
        if($value == null) $value ="";

        $privateSelected = ($value == 0) ? "selected='selected'" : "";
        $publicSelected = ($value == 1) ? "selected='selected'" : "";
    	return "<div class='form-group'>
    				<select class='form-control' name='privacyInput'>
					      <option value='0' $privateSelected>Private</option>
					      <option value='1' $publicSelected>Public</option>
					</select>
    			</div>";
    } // End of private function createPrivacyInput()

    private function CreateCategoriesInput($value) {
        if($value == null) $value ="";
    	$query = $this->con->prepare("SELECT * FROM categories");
		$query->execute();

		$html = "<div class='form-group'> 
					<select class='form-control' name='categoryInput'";
				
		while($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$name = $row["name"];
			$id = $row["id"];
            $Selected = ($id == $value) ? "selected='selected'" : "";

			$html .= "<option $Selected value='$id'>$name</option>";
		}

		$html .= "</select>
				</div>";

		return $html;
    } // End of private function CreateCategoriesInput

    private function createUploadButton() {
    	return "<button type='submit' class='btn btn-primary' name='uploadButton'>Upload</button>";
    } // End of private function createUploadButton



    





} // end of Class VideoDetailsFormProvider


?>
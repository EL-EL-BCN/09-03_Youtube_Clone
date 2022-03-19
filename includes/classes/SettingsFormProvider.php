<?php
class SettingsFormProvider {

    public function createUserDetailsForm($firstName, $lastName, $email) {
        $firstNameInput = $this->createFirstNameInput($firstName);
        $lastNameInput = $this->createLastNameInput($lastName);
        $emailInput = $this->createEmailInput($email);
        $SaveButton = $this->createSaveUserDetailsButton();
                
        return "<form action='settings.php' method='POST' enctype='multipart/form-data'>
                    <span class='title'>User details</span>
                    $firstNameInput
                    $lastNameInput
                    $emailInput
                    $SaveButton
                </form>";
    } // End of public function createUploadForm

    public function createPasswordForm() {
        $oldPasswordInput = $this->createPasswordInput("oldPassword", "Old password");
        $newPassword1Input = $this->createPasswordInput("newPassword", "New password");
        $newPassword2Input = $this->createPasswordInput("newPassword2", "Confirm new password");

        $saveButton = $this->createSavePasswordButton();

        return "<form action='settings.php' method='POST' enctype='multipart/form-data'>
                    <span class='title'>Update password</span>
                    $oldPasswordInput
                    $newPassword1Input
                    $newPassword2Input
                    $saveButton
                </form>";
    } // End of public function createPasswordForm

    private function createfirstNameInput($value) {
        if($value == null) $value = "";
        return "<div class='form-group'>
                    <input class='form-control' type='text' placeholder='First name' name='firstName' value='$value' required>
                </div>";
    } // End of private function createfirstNameInput

    private function createLastNameInput($value) {
        if($value == null) $value = "";
        return "<div class='form-group'>
                    <input class='form-control' type='text' placeholder='last name' name='lastName' value='$value' required>
                </div>";
    } // End of private function createlastNameInput

    private function createEmailInput($value) {
        if($value == null) $value = "";
        return "<div class='form-group'>
                    <input class='form-control' type='email' placeholder='Email' name='email' value='$value' required>
                </div>";
    } // End of private function createlastNameInput

    private function createSaveUserDetailsButton() {
    	return "<button type='submit' class='btn btn-primary' name='saveDetailsButton'>Save</button>";
    } // End of private function createUploadButton

    private function createPasswordInput($name, $placeholder) {
        
        return "<div class='form-group'>
                    <input class='form-control' type='password' placeholder='$placeholder' name='$name' required>
                </div>";
    } // End of private function createfirstNameInput

    private function createSavePasswordButton() {
        return "<button type='submit' class='btn btn-primary' name='savePasswordButton'>Save</button>";
    } // End of private function createUploadButton





} // end of Class SetingsFormProvider
?>
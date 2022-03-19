<?php
class ButtonProvider {

    public static $signInFunction = "notSignedIn()";

    public static function createLink($link) {
        return User::isLoggedIn() ? $link : ButtonProvider::$signInFunction;
	} // End of public static function createLink

    public static function createButton($text, $imageSrc, $action, $class) {

        $image = ($imageSrc == null) ? "" : "<img src='$imageSrc'>";

        $action  = ButtonProvider::createLink($action);

        return "<button class='$class' onclick='$action'>
                    $image
                    <span class='text'>$text</span>
                </button>";
	} // End of public static function CreateButton

    public static function createHyperlinkButton($text, $imageSrc, $href, $class) {

        $image = ($imageSrc == null) ? "" : "<img src='$imageSrc'>";

        return "<a href='$href'>
                    <button class='$class'>
                        $image
                        <span class='text'>$text</span>
                    </button>
                </a>";
	} // End of public static function createHyperlinkButton

    public static function createUserProfileButton($con, $username) {
        $userObj = new User($con, $username);
        $profilePic = $userObj->getProfilePic();
        $link = "profile.php?username=$username";

        return "<a href='$link'>
                    <img src='$profilePic' class='profilePicture'>
                </a>";
		} // End of public static function createUserProfileButton

    public static function createEditVideoButton($videoId) {
        $href = "editVideo.php?videoId=$videoId";

        $button = ButtonProvider::createHyperlinkButton("EDIT VIDEO", null, $href, "edit button");

        return "<div class='editVideoButtonContainer'>
                    $button
                </div>";
	} // End of public static function createEditVideoButton

    public static function createSubscriberButton($con, $userToObj, $userLoggedInObj) {
        $userTo = $userToObj->getUsername();
        $userLoggedIn = $userLoggedInObj->getUsername();

        $isSubscribedTo = $userLoggedInObj->isSubscribedTo($userTo);
        $buttonText = $isSubscribedTo ? "SUBSCRIBED" : "SUBSCRIBE";
        $buttonText .= " " . $userToObj->getSubscriberCount();

        $buttonClass = $isSubscribedTo ? "unsubscribe button" : "subscribe button";
        $action = "subscribe(\"$userTo\", \"$userLoggedIn\", this)";

        $button = ButtonProvider::createButton($buttonText, null, $action, $buttonClass);

        return "<div class='subscribeButtonContainer'>
                    $button
                </div>";
    } // End of public static function createSuscriberButton

    public static function createUserProfileNavigationButton($con, $username) {
        if(user::isLoggedIn()) {
            return ButtonProvider::createUserProfileButton($con, $username);
        }
        else {
            return "<a href='signIn.php'>
                        <span class='signInLink'>SIGN IN</span>
                    </a>";
        }
    } // End of public static function createUserProfileNavigationButton




} // End of class ButtonProvider
?>
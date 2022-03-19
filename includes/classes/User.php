<?php 
class User {

private $con, $sqlData;

	public function __construct($con, $username) {
		$this->con = $con;
	
		$query = $this->con->prepare("SELECT * FROM users WHERE username = :un");
		$query->bindParam(":un", $username);
		$query->execute();

		$this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
	} // End of constructor

	public static function isLoggedIn() {
		return isset($_SESSION["userLoggedIn"]);
	} // End of public static function isLoggedIn

	public function getUsername() {
		return $this->sqlData["username"] ??= 'default value';
	} // End of public function getUsername

	public function getName() {
		return $this->sqlData["firstName"] . " " . $this->sqlData["lastName"];
	} // End of public function getName

	public function getFirstName() {
		return $this->sqlData["firstName"];
	} // End of public function getFirstName

	public function getLastName() {
		return $this->sqlData["lastName"];
	} // End of public function getLastName

	public function getEmail() {
		return $this->sqlData["email"];
	} // End of public function getEmail

	public function getProfilePic() {
		return $this->sqlData["profilePic"] ??= 'default value';
	} // End of public function getEmail

	public function getSignUpDate() {
		return $this->sqlData["signUpDate"];
	} // End of public function getEmail

    public function isSubscribedTo($userTo) {
        $query = $this->con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $username);
        $username = $this->getUsername();
        $query->execute();
        return $query->rowCount() > 0;
	} // End of public function isSubscribedTo

    public function getSubscriberCount() {
        $query = $this->con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo");
        $query->bindParam(":userTo", $username);
        $username = $this->getUsername();
        $query->execute();
        return $query->rowCount();
	} // End of public function getSubscriberCount

	public function getSubscriptions() {
        $query = $this->con->prepare("SELECT userTo FROM subscribers WHERE userFrom=:userFrom");
        $username = $this->getUsername();
        $query->bindParam(":userFrom", $username);
        $query->execute();
        
        $subs = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($this->con, $row["userTo"]);
            array_push($subs, $user);
        }
        return $subs;
	} // End of public function getSubscriptions

} // End of class User
?>
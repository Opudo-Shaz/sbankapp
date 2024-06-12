<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
$to = "opudosharon6@gmail.com, sharondeveloper02@gmail.com";
$subject = "Mail from PHP";
$message = "Hi,\r\nThis mail has been sent using PHP!";
$success = mail($to, $subject, $message);
if ($success) {
$response = "Message has been sent successfully.";
} else {
$response = "The message could not be sent.";
}
echo $response;
echo " ";

class Vehicle {
var $brand;
var $speed = 80;

function setSpeed($speedValue) {
$this->speed = $speedValue;
} 
function setBrand($brandName) {
$this->brand = $brandName;
}
function
printDetails(){

echo "Vehicle brand is: ".$this->brand;
echo " ";
echo "Vehicle speed is: ".$this->speed;
}
}
$myCar = new Vehicle;
$myCar->setBrand("Audi");
$myCar->setSpeed(120);
$myCar->printDetails();

?>

<?php
/**
* Methods for database handling.
*/
class DB extends SQLite3 {
const DATABASE_NAME = ’users.db’;
const BCRYPT_COST = 14;
/**
* DB class constructor. Initialize method is called, which will create users table if
it does
* not exist already.
*/
function __construct() {
$this->open(self::DATABASE_NAME);
$this->initialize();
}
/**
* Creates the table if it does not exist already.
*/
protected function initialize() {
    $sql = ’CREATE TABLE IF NOT EXISTS user (
        username STRING UNIQUE NOT NULL,
        password STRING NOT NULL
        )’;
        $this->exec($sql);
        }
        /**
        * Authenticates the given user with the given password. If the user does not exist,
        any action
        is
        performed. If it exists, its stored password is retrieved, and then ←-
        *
        password_verify
        * built-in function will check that the supplied password matches the derived one.
        *
        * @param $username The username to authenticate.
        * @param $password The password to authenticate the user.
        * @return True if the password matches for the username, false if not.
        */
        public function authenticateUser($username, $password) {
        if ($this->userExists($username)) {
        $storedPassword = $this->getUsersPassword($username);
        if (password_verify($password, $storedPassword)) {
        $authenticated = true;
        } else {
        $authenticated = false;
        }
        } else {
        $authenticated = false;
        }
        return $authenticated;
        }
        /**
        * Checks if the given users exists in the database.
        *
        * @param $username The username to check if exists.
        * @return True if the users exists, false if not.
        */
        protected function userExists($username) {
        $sql = ’SELECT COUNT(*) AS count
        FROM
        user
        WHERE username = :username’;
        $statement = $this->prepare($sql);
        $statement->bindValue(’:username’, $username);
        $result = $statement->execute();
        $row = $result->fetchArray();
        $exists = ($row[’count’] === 1) ? true : false;
        $statement->close();
        return $exists;
        }
        
<?php
class Account {

    private $conn;
    private $errorArray = array();

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // REGISTER
    public function register($fn, $ln, $un, $em, $em2, $pw, $pw2) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUsername($un);
        $this->validateEmails($em, $em2);
        $this->validatePasswords($pw,$pw2);

        if(empty($this->errorArray)) {
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
        }
        return false;
    }

    // LOGIN
    public function login($un, $pw) {
        $pw = hash("sha512", $pw); // Mã hóa password bằng hàm hash()

        $query = $this->conn->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        $query->bindValue(":un", $un);
        $query->bindValue(":pw", $pw);

        $query->execute();

        if($query->rowCount() == 1) {
            return true;
        }

        array_push($this->errorArray, Constants::$loginFailed);
        return false;
    }

    // INSERT DATA TO DATABASE
    private function insertUserDetails($fn, $ln, $un, $em, $pw) {
        $pw = hash("sha512", $pw); // Mã hóa password bằng hàm hash()

        $query = $this->conn->prepare("INSERT INTO users (firstName, lastName, username, email, password)
                                        VALUES (:fn, :ln, :un, :em, :pw)");
        $query->bindValue(":fn", $fn);
        $query->bindValue(":ln", $ln);
        $query->bindValue(":un", $un);
        $query->bindValue(":em", $em);
        $query->bindValue(":pw", $pw);

        return $query->execute();
    }

    // CHECK VALIDATE FORM REGISTER AND LOGIN
    private function validateFirstName($fn) {
        if(strlen($fn) < 2 || strlen($fn) > 25) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($ln) {
        if(strlen($ln) < 2 || strlen($ln) > 25) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    private function validateUsername($un) {
        if(strlen($un) < 2 || strlen($un) > 25) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        $query = $this->conn->prepare("SELECT  * FROM users WHERE username=:un");
        $query->bindValue(":un", $un);

        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }

    private function validateEmails($em, $em2) {
        if($em != $em2) {
            array_push($this->errorArray, Constants::$emailsDontMatch);
            return;
        }

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
        }

        $query = $this->conn->prepare("SELECT  * FROM users WHERE email=:em");
        $query->bindValue(":em", $em);

        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validatePasswords($pw, $pws2) {
        if($pw != $pws2) {
            array_push($this->errorArray, Constants::$passwordsDontMatch);
            return;
        }

        if(strlen($pw) < 5 || strlen($pw) > 25) {
            array_push($this->errorArray, Constants::$passwordLength);
        }
    }

    // RETURN ERROR VIEWS
    public function getError($error) {
        if(in_array($error, $this->errorArray)) {
            if(in_array($error, $this->errorArray)) {
                return "<span class='errorMessage'>$error</span>";
            }
        }
    }
}
?>
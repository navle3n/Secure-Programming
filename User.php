//User.php

<?php

class User {
    private $username;
    private $password;
    private $retypepass;
    private $education;
    private $phonenumber;
    private $DOB;
    private $COR;
    private $street;
    private $number;
    private $postcode;
    private $JSON;

    // Getter and setter for $username
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    // Getter and setter for $password
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    // Getter and setter for $retypepass
    public function getRetypepass() {
        return $this->retypepass;
    }

    public function setRetypepass($retypepass) {
        $this->retypepass = $retypepass;
    }

    // Getter and setter for $education
    public function getEducation() {
        return $this->education;
    }

    public function setEducation($education) {
        $this->education = $education;
    }

    // Getter and setter for $phonenumber
    public function getPhonenumber() {
        return $this->phonenumber;
    }

    public function setPhonenumber($phonenumber) {
        $this->phonenumber = $phonenumber;
    }

    // Getter and setter for $DOB
    public function getDOB() {
        return $this->DOB;
    }

    public function setDOB($DOB) {
        $this->DOB = $DOB;
    }

    // Getter and setter for $COR
    public function getCOR() {
        return $this->COR;
    }

    public function setCOR($COR) {
        $this->COR = $COR;
    }

    // Getter and setter for $street
    public function getStreet() {
        return $this->street;
    }

    public function setStreet($street) {
        $this->street = $street;
    }

    // Getter and setter for $number
    public function getNumber() {
        return $this->number;
    }

    public function setNumber($number) {
        $this->number = $number;
    }

    // Getter and setter for $postcode
    public function getPostcode() {
        return $this->postcode;
    }

    public function setPostcode($postcode) {
        $this->postcode = $postcode;
    }

    // Getter and setter for $JSON
    public function getJSON() {
        return $this->JSON;
    }

    public function setJSON($JSON) {
        $this->JSON = $JSON;
    }

}

?>

<?php
require_once 'User.php';
require_once 'UserBuilder.php';

class ConcreteUserBuilder implements UserBuilder {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function setUsername($username) {
        $this->user->setUsername($username);
        return $this;
    }

    public function setPassword($password) {
        $this->user->setPassword($password);
        return $this;
    }

    public function setRetypepass($retypepass) {
        $this->user->setRetypepass($retypepass);
        return $this;
    }

    public function setEducation($education) {
        $this->user->setEducation($education);
        return $this;
    }

    public function setPhonenumber($phonenumber) {
        $this->user->setPhonenumber($phonenumber);
        return $this;
    }

    public function setDOB($DOB) {
        $this->user->setDOB($DOB);
        return $this;
    }

    public function setCOR($COR) {
        $this->user->setCOR($COR);
        return $this;
    }

    public function setStreet($street) {
        $this->user->setStreet($street);
        return $this;
    }

    public function setNumber($number) {
        $this->user->setNumber($number);
        return $this;
    }

    public function setPostcode($postcode) {
        $this->user->setPostcode($postcode);
        return $this;
    }

    public function setJSON($JSON) {
        $this->user->setJSON($JSON);
        return $this;
    }

    public function build() {
        if ($this->user->getPassword() !== $this->user->getRetypepass()) {
            throw new \Exception('Passwords do not match.');
        }
        return clone $this->user;
    }
}
?>
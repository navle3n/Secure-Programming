<?php
interface UserBuilder {
    public function setUsername($username);
    public function setPassword($password);
    public function setRetypepass($retypepass);
    public function setEducation($education);
    public function setPhonenumber($phonenumber);
    public function setDOB($DOB);
    public function setCOR($COR);
    public function setStreet($street);
    public function setNumber($number);
    public function setPostcode($postcode);
    public function setJSON($JSON);
    public function build();
}

?>

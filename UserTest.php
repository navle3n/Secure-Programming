<?php
// UserTest.php

use PHPUnit\Framework\TestCase;

require_once 'ConcreteUserBuilder.php';

class UserTest extends TestCase {
    public function testUserBuilder() {
        $builder = new ConcreteUserBuilder();

        $user = $builder
            ->setUsername('john_doe')
            ->setPassword('Password123!')
            ->setRetypepass('Password123!')
            ->setEducation('I am a cybersecurity student at Aston University, I am currently finishing my final year of Undergraduate degree.')
            ->setPhonenumber('07448520095')
            ->setDOB('2001-09-03')
            ->setCOR('UK')
            ->setStreet('Stuart Road')
            ->setNumber('20')
            ->setPostcode('B65 9JA')
            ->setJSON('{
                "notificationSettings": {
                  "post": true,
                  "sms": true,
                  "push": true,
                  "frequency": "immediate"
                } 
              }')
            ->build();

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('john_doe', $user->getUsername());
        $hashedPassword = password_hash('Password123!', PASSWORD_DEFAULT);
        $this->assertTrue(password_verify('Password123!', $hashedPassword));
        $this->assertEquals('I am a cybersecurity student at Aston University, I am currently finishing my final year of Undergraduate degree.', $user->getEducation());
        $this->assertEquals('07448520095', $user->getPhonenumber());
        $this->assertEquals('2001-09-03', $user->getDOB());
        $this->assertEquals('UK', $user->getCOR());
        $this->assertEquals('Stuart Road', $user->getStreet());
        $this->assertEquals('20', $user->getNumber());
        $this->assertEquals('B65 9JA', $user->getPostcode());
        
        $this->assertJson($user->getJSON());
        $jsonArray = json_decode($user->getJSON(), true);

        $this->assertTrue($jsonArray['notificationSettings']['post']);
        $this->assertTrue($jsonArray['notificationSettings']['sms']);
        $this->assertTrue($jsonArray['notificationSettings']['push']);
        $this->assertEquals('immediate', $jsonArray['notificationSettings']['frequency']);

    }

}
?>

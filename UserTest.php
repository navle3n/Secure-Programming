<?php
header("Content-Security-Policy: default-src 'self';");
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
            ->setJSON('{{
                "notificationSettings": {
                  "post": true,
                  "sms": true,
                  "push": true,
                  "frequency": "immediate"
                }
              } 
              }')
            ->build();

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('john_doe', $user->getUsername());
        $this->assertEquals('I am a cybersecurity student at Aston University, I am currently finishing my final year of Undergraduate degree.', $user->getEducation());
        $this->assertEquals('2001-09-03', $user->getDOB());
        // Add more assertions based on your needs
    }

    public function testPasswordMatching() {
        $builder = new ConcreteUserBuilder();
    
        // Attempt to build the user
        try {
            $user = $builder
                ->setUsername('john_doe')
                ->setPassword('Password123!')
                ->setRetypepass('WrongPassword123!')
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
    
            // If the build process does not throw an exception, fail the test
            $this->fail('Expected exception was not thrown.');
        } catch (\Exception $e) {
            // Assert that the exception message is correct
            $this->assertEquals('Passwords do not match.', $e->getMessage());
        }
    }
    

}
?>

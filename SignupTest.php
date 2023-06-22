<?php
use PHPUnit\Framework\TestCase;

interface DatabaseConnectionInterface {
    public function query($query);
    public function getInsertId();
}

class MockDatabaseConnection implements DatabaseConnectionInterface {
    private $insertId;

    public function __construct($insertId) {
        $this->insertId = $insertId;
    }

    public function query($query) {
        return true;
    }

    public function getInsertId() {
        return $this->insertId;
    }
}

class SignupTest extends TestCase {
    public function testSignup() {
        // Set up the necessary variables
        $_POST['submit'] = true;
        $_POST['firstname'] = 'John';
        $_POST['lastname'] = 'Doe';
        $_POST['username'] = 'johndoe';
        $_POST['password'] = 'password123';
        $_POST['email'] = 'johndoe@example.com';
        $_POST['phone_number'] = '1234567890';
        $_POST['home_address'] = '123 Main St';
        $_POST['role'] = 'buyer';

        // Create a mock database connection
        $mockConnection = new MockDatabaseConnection(1);

        // Include the signup.php file
        ob_start();
        include 'signup.php';
        $output = ob_get_clean();

        // Assertions
        $this->assertStringContainsString('Successfully saved.', $output);
    }
}

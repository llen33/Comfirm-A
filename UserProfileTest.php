<?php
require 'vendor/autoload.php'; // Include the Composer autoloader to load PHPUnit and other dependencies.

class UserProfileTest extends \PHPUnit\Framework\TestCase // Define a test class named UserProfileTest that extends PHPUnit's TestCase class.
{
    protected static $conn; // Declare a static property to hold the database connection.

    public static function setUpBeforeClass(): void
    {
        // Establish a database connection
        self::$conn = new mysqli('localhost', 'root', '', 'student_marketplace23'); // Set up a database connection using MySQLi.
        if (self::$conn->connect_error) {
            die('Connection failed: ' . self::$conn->connect_error); // Terminate the script and display an error message if the database connection fails.
        }
    }

    public static function tearDownAfterClass(): void
    {
        // Close the database connection
        self::$conn->close(); // Close the previously established database connection.
    }

    public function setUp(): void
    {
        // Prepare test data in the database
        // You can insert test records specific to your test cases
        self::$conn->query("INSERT INTO contact_test (contact_id, name, subject, contact_desc, user_email)
                            VALUES (1, 'John Doe', 'Test Subject', 'Test Description', 'test@example.com')"); // Insert test data into the 'contact_test' table in the database.
    }

    public function tearDown(): void
    {
        // Clean up the test data in the database
        // self::$conn->query("DELETE FROM contact");
    }

    public function testUserProfilePage()
    {
        // Arrange
        $expectedContactId = 1; // Set the expected values for the test data.
        $expectedName = 'John Doe';
        $expectedSubject = 'Test Subject';
        $expectedContactDesc = 'Test Description';
        $expectedUserEmail = 'test@example.com';

        // Act
        ob_start(); // Start output buffering to capture the output of the included 'user_profile.php' script.
        include 'user_profile.php'; // Include the 'user_profile.php' script to run the code.
        $output = ob_get_clean(); // Capture the output generated by the 'user_profile.php' script and stop output buffering.

        // Assert
        $this->assertStringContainsString('<td>' . $expectedContactId . '</td>', $output); // Assert that the output contains the expected contact ID.
        $this->assertStringContainsString('<h5 class="font-medium mb-0">' . $expectedName . '</h5>', $output); // Assert that the output contains the expected name.
        $this->assertStringContainsString('<span class="text-muted">' . $expectedSubject . '</span><br>', $output); // Assert that the output contains the expected subject.
        $this->assertStringContainsString('<span class="text-muted">' . $expectedContactDesc . '</span><br>', $output); // Assert that the output contains the expected contact description.
        $this->assertStringContainsString('<span class="text-muted">' . $expectedUserEmail . '</span><br>', $output); // Assert that the output contains the expected user email.
    }
}
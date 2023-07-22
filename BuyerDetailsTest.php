<?php
require 'vendor/autoload.php'; // Include the Composer autoloader to load PHPUnit and other dependencies.

class BuyerDetailsTest extends \PHPUnit\Framework\TestCase // Define a test class named BuyerDetailsTest that extends PHPUnit's TestCase class.
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

    public function testRetrieveBuyerDetails()
    {
        // Arrange
        $expectedBuyersCount = 11; // Set the expected number of buyers in the database.

        // Act
        $buyers = $this->retrieveBuyerDetails(); // Call the private method retrieveBuyerDetails to retrieve buyer details from the database.

        // Assert
        $this->assertCount($expectedBuyersCount, $buyers); // Assert that the number of buyers retrieved from the database matches the expected count.
        $this->assertContainsOnly('array', $buyers); // Assert that all elements in the $buyers array are of type 'array'.
    }

    private function retrieveBuyerDetails()
    {
        // Retrieve buyer details from the database
        $query = "SELECT * FROM users WHERE role = 'buyer'"; // Define the SQL query to select all users with the role 'buyer'.
        $result = mysqli_query(self::$conn, $query); // Execute the query using the established database connection.

        $buyers = []; // Initialize an empty array to store buyer details.
        if ($result && mysqli_num_rows($result) > 0) { // Check if the query was successful and if there are any rows in the result.
            while ($row = mysqli_fetch_assoc($result)) { // Loop through the result set and fetch each row as an associative array.
                $buyers[] = $row; // Add each buyer's details to the $buyers array.
            }
        }

        return $buyers; // Return the array of buyer details.
    }
}

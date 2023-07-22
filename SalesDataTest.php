<?php
require 'vendor/autoload.php'; // Include the Composer autoloader to load PHPUnit and other dependencies.

class SalesDataTest extends \PHPUnit\Framework\TestCase // Define a test class named SalesDataTest that extends PHPUnit's TestCase class.
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

    public function testRetrieveSalesData()
    {
        // Arrange
        $expectedDates = ['2023-07-03', '2023-07-04', '2023-07-05', '2023-07-07', '2023-07-09', '2023-07-10']; // Set the expected dates for the sales data.
        $expectedSales = [1, 1, 1, 1, 6, 1]; // Set the expected sales count for each date. Update the values based on the actual sales data.

        // Act
        $response = $this->retrieveSalesData(7, 2023); // Call the method retrieveSalesData with the desired month (July) and year (2023) to retrieve the sales data.
        $actualDates = $response['dates']; // Extract the actual dates from the response.
        $actualSales = $response['sales']; // Extract the actual sales count from the response.

        // Convert the actual sales data to integers
        $actualSales = array_map('intval', $actualSales); // Convert each element of the $actualSales array to an integer.

        // Assert
        $this->assertEquals($expectedDates, $actualDates); // Assert that the actual dates match the expected dates.
        $this->assertEquals($expectedSales, $actualSales); // Assert that the actual sales count matches the expected sales count.
    }

    protected function retrieveSalesData($month, $year)
    {
        // Retrieve sales data for the specified month and year
        $query = "SELECT DATE(order_date) AS order_date, COUNT(DISTINCT CONCAT(DATE(order_date), order_id)) AS sales_count FROM test_order WHERE MONTH(order_date) = $month AND YEAR(order_date) = $year GROUP BY DATE(order_date)"; // SQL query to get sales data for the specified month and year.
        $result = mysqli_query(self::$conn, $query); // Execute the query using the established database connection.

        // Initialize arrays for chart data
        $dates = array(); // Array to store dates.
        $sales = array(); // Array to store sales count.

        // Process the sales data
        while ($row = mysqli_fetch_assoc($result)) { // Loop through the result set and fetch each row as an associative array.
            $dates[] = $row['order_date']; // Add the order date to the $dates array.
            $sales[] = $row['sales_count']; // Add the sales count to the $sales array.
        }

        // Prepare the response as an array
        $response = array(
            'dates' => $dates, // Assign the $dates array to the 'dates' key in the response array.
            'sales' => $sales // Assign the $sales array to the 'sales' key in the response array.
        );

        return $response; // Return the response array containing the dates and sales count.
    }
}

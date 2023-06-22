<?php
// Import the necessary dependencies for testing
use PHPUnit\Framework\TestCase;

require_once 'config.php';

class LoginTest extends TestCase
{
    protected function setUp(): void
    {
        // Set up the database connection
        global $conn;
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Disable foreign key checks
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

        // Clear any existing data from the users, seller, and buyer tables
        mysqli_query($conn, "DELETE FROM seller");
        mysqli_query($conn, "DELETE FROM buyer");
        mysqli_query($conn, "DELETE FROM users");

        // Insert test data into the users table
        mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('seller', 'sellerpassword', 'seller')");
        mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('buyer', 'buyerpassword', 'buyer')");

        // Enable foreign key checks
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
    }

    protected function tearDown(): void
    {
        // Clean up the database after testing
        global $conn;
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

        // Clear any existing data from the users, seller, and buyer tables
        mysqli_query($conn, "DELETE FROM seller");
        mysqli_query($conn, "DELETE FROM buyer");
        mysqli_query($conn, "DELETE FROM users");

        // Enable foreign key checks
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

        mysqli_close($conn);
    }

    public function testSellerLogin(): void
    {
        // Simulate a POST request with seller credentials
        $_POST['username'] = 'seller';
        $_POST['password'] = 'sellerpassword';

        ob_start();
        include 'loginn.php';
        $output = ob_get_clean();

        // Assert that the seller is redirected to the seller homepage
        $this->assertStringContainsString('Location: index_seller.php', $output);

        // Assert that the session variables are set correctly
        $this->assertEquals($_SESSION['username'], 'seller');
        $this->assertEquals($_SESSION['role'], 'seller');

        // Assert that the seller_id session variable is null
        $this->assertNull($_SESSION['seller_id']);
    }

    public function testBuyerLogin(): void
    {
        // Simulate a POST request with buyer credentials
        $_POST['username'] = 'buyer';
        $_POST['password'] = 'buyerpassword';

        ob_start();
        include 'loginn.php';
        $output = ob_get_clean();

        // Assert that the buyer is redirected to the buyer homepage
        $this->assertStringContainsString('Location: index_buyer.php', $output);

        // Assert that the session variables are set correctly
        $this->assertEquals($_SESSION['username'], 'buyer');
        $this->assertEquals($_SESSION['role'], 'buyer');

        // Assert that the buyer_id session variable is null
        $this->assertNull($_SESSION['buyer_id']);
    }

    public function testInvalidCredentials(): void
    {
        // Simulate a POST request with invalid credentials
        $_POST['username'] = 'invaliduser';
        $_POST['password'] = 'invalidpassword';

        ob_start();
        include 'loginn.php';
        $output = ob_get_clean();

        // Assert that the user is redirected to the login page with an error message
        $this->assertStringContainsString('Location: login.php?error=Incorrect username or password', $output);
    }
}

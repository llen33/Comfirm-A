<?php

    use PHPUnit\Framework\TestCase;

    class AddProductTest extends TestCase
    {
        protected function setUp(): void
        {
            parent::setUp();

            // Disable foreign key checks before running the test
            $conn = mysqli_connect('localhost', 'root', '', 'student_marketplace');
            mysqli_query($conn, 'SET FOREIGN_KEY_CHECKS = 0;');
        }

        public function testAddProduct()
        {
            // Create a temporary file for upload
            $tempFile = tempnam(sys_get_temp_dir(), 'test_image');
            $tempFilePath = $tempFile . '.png';
            file_put_contents($tempFilePath, 'test_image_content');
            $_FILES['product_image'] = [
                'name' => 'test_image.png',
                'tmp_name' => $tempFilePath,
                'type' => 'image/png',
                'error' => UPLOAD_ERR_OK,
                'size' => filesize($tempFilePath)
            ];

            // Set the form data
            $_POST['add_product'] = true;
            $_POST['product_name'] = 'Test Product';
            $_POST['product_price'] = 9.99;
            $_POST['product_description'] = 'This is a test product';
            $_POST['product_category'] = 'Test Category';
            $_POST['product_quantity'] = 10;
            $_POST['product_condition'] = 'Test Condition';

            // Start the session
            session_start();
            $_SESSION['seller_id'] = 7; // Set the desired seller ID

            // Include the add_product.php file
            ob_start();
            require 'add_product.php';
            $output = ob_get_clean();

            // Assert that the product was added successfully
            $this->assertStringContainsString('New Product Added Successfully', $output);

            // Assert the database insertion
            $conn = mysqli_connect('localhost', 'root', '', 'student_marketplace');
            $query = "SELECT * FROM products WHERE name = 'Test Product'";
            $result = mysqli_query($conn, $query);
            $this->assertEquals(1, mysqli_num_rows($result));

            // Clean up the temporary file
            unlink($tempFilePath);
        }

        protected function tearDown(): void
        {
            // Re-enable foreign key checks after the test
            $conn = mysqli_connect('localhost', 'root', '', 'student_marketplace');
            mysqli_query($conn, 'SET FOREIGN_KEY_CHECKS = 1;');

            parent::tearDown();
        }
    }
    
?>
<!-- This code is written by Eng Jing Yi (CSD21005) -->

<?php

    use PHPUnit\Framework\TestCase;

    class SellerProfileTest extends TestCase
    {
        public function testSellerProfile()
        {
            // Set the desired seller ID
            $sellerId = 7;

            // Start the session and set the seller ID
            session_start();
            $_SESSION['seller_id'] = $sellerId;

            // Include the seller_profile.php file
            ob_start();
            require 'seller_profile.php';
            $output = ob_get_clean();

            // Assert that the seller profile is displayed correctly
            $this->assertStringContainsString('My Seller Profile', $output);
            $this->assertStringContainsString('First Name:', $output);
            $this->assertStringContainsString('Last Name:', $output);
            $this->assertStringContainsString('Gender:', $output);
            $this->assertStringContainsString('Birth Date:', $output);
            $this->assertStringContainsString('Username:', $output);
            $this->assertStringContainsString('Email:', $output);
            $this->assertStringContainsString('Phone Number:', $output);
            $this->assertStringContainsString('Home Address:', $output);
            $this->assertStringContainsString('Bio:', $output);
            $this->assertStringContainsString('School:', $output);
            $this->assertStringContainsString('Edit', $output);
        }
    }
    
?>

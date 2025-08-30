<?php
// Start the session for cart management
session_start();

// Database connection setup
$host = 'localhost';  // Database host
$username = 'root';   // Database username
$password = '';       // Database password
$dbname = 'sutocafe'; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['customer_name'];
    $email = $_POST['customer_email'];
    $phone = $_POST['customer_phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];

    // Prepare the SQL query to insert data into the orders table
    $sql = "INSERT INTO orders (name, email, phone, address, city, zipcode) 
            VALUES ('$name', '$email', '$phone', '$address', '$city', '$zipcode')";

    if ($conn->query($sql) === TRUE) {
        // After the successful order submission, redirect to a Thank You page
        header("Location: thank_you.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suto Café - Premium Ocean-Inspired Coffee Experience</title>
    <meta name="description" content="Experience Suto Café's premium coffee, artisanal dishes, and ocean-inspired ambiance. Order online, book tables, and explore our franchise story.">
    <meta name="keywords" content="premium coffee, ocean café, artisanal food, franchise coffee, online ordering, table booking">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm shadow-lg z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <h1 class="text-2xl font-serif font-bold text-blue-600">Suto Café</h1>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#home" class="nav-link px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Home</a>
                        <a href="#menu" class="nav-link px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Menu</a>
                        <a href="#order" class="nav-link px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Order Online</a>
                        <a href="#contact" class="nav-link px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">Contact</a>
                        <a href="#about" class="nav-link px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">About</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <!-- Checkout Section -->
        <section id="order" class="min-h-screen py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <h1 class="text-4xl font-serif text-center mb-12">Order Online</h1>
                
                <!-- Checkout Form -->
                <form action="" method="POST">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
                            <div class="space-y-4">
                                <input type="text" name="customer_name" placeholder="Full Name" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600">
                                <input type="email" name="customer_email" placeholder="Email" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600">
                                <input type="tel" name="customer_phone" placeholder="Phone" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600">
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Order Details</h3>
                            <div id="order-details">
                                <!-- Dynamically populated order details -->
                                <?php 
                                    // Example of how you might display cart items from a session
                                    // Assuming you store cart data in a session
                                    if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){
                                        foreach ($_SESSION['cart'] as $item) {
                                            echo "<p>".$item['name']." - ".$item['quantity']." x $".$item['price']."</p>";
                                        }
                                    } else {
                                        echo "<p>No items in your cart.</p>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-4">Payment</h3>
                        <div class="space-y-4">
                            <input type="text" name="card-number" placeholder="Card Number" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600">
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" name="expiry" placeholder="MM/YY" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600">
                                <input type="text" name="cvc" placeholder="CVC" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600">
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        <button type="button" onclick="cancelOrder()" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Place Order
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Thank You Page -->
        <section id="thank-you" class="hidden">
            <h1>Thank You for Your Order!</h1>
            <p>You will be redirected shortly.</p>
        </section>
    </main>

    <script>
        // JavaScript logic for cart functionality and form handling
        setTimeout(function() {
            window.location.href = 'https://www.sutocafe.com';  // Redirect after 5 seconds
        }, 5000);
    </script>
</body>
</html>

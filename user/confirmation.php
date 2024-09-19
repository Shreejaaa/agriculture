<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
function send_mail($email, $message)
{
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/SMTP.php';

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'koko.mitsuu@gmail.com';
        $mail->Password = 'oiov bjhy xxcl tcbp';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('koko.mitsuu@gmail.com', 'Irrigation');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Receipt from Irrigation';
        $mail->Body = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>

<?php


include("../admin_and_user/connection.php");

session_start();

if (!isset($_SESSION['username'])) {
    header("Location:../admin_and_user/signin_up.php");
    exit();
}

$user_id = $_SESSION['customer_id'];

if ($conn->connect_error) {
    echo "<script>alert('Error connecting to database: " . $conn->connect_error . "')</script>";
    exit();
}

// Get the user's cart ID
$query = "SELECT cart_id FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);

if (!$stmt->execute()) {
    echo "<script>alert('Error executing query: " . $stmt->error . "')</script>";
    exit();
}

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "<script>alert('No cart found for user.')</script>";
    exit();
}

$cart_id = $row['cart_id'];

// Get the products in the user's cart
$query = "
    SELECT CI.product_id, P.name, P.price, P.description, P.image, CI.product_quantity 
    FROM cart_item CI 
    JOIN product P ON CI.product_id = P.id 
    WHERE CI.cart_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $cart_id);

if (!$stmt->execute()) {
    echo "<script>alert('Error executing query: " . $stmt->error . "')</script>";
    exit();
}

$result = $stmt->get_result();

// Get user details
$query_user = "SELECT username, email, contact FROM users WHERE userid = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param('i', $user_id);

if (!$stmt_user->execute()) {
    echo "<script>alert('Error executing query: " . $stmt_user->error . "')</script>";
    exit();
}

$user_result = $stmt_user->get_result();
$user = $user_result->fetch_assoc();

$total_price = 0;
$products = "";
while ($row = $result->fetch_assoc()) {
    $product_id = $row['product_id'];
    $product_name = $row['name'];
    $product_price = $row['price'];
    $product_image = $row['image'];
    $description = $row['description'];
    $product_quantity = $row['product_quantity'];
    $item_total_price = $product_price * $product_quantity;
    $total_price += $item_total_price;
    
    $products .= "
    <tr>
        <td>$product_name</td>
        <td>\$$product_price</td>
        <td>$product_quantity</td>
        <td>\$$item_total_price</td>
    </tr>";
}

$shipping_charge = 0;
$discount_percentage = 0.10; 
$discount = $total_price * $discount_percentage; 
$final_amount = $total_price + $shipping_charge - $discount;

$message = "
<h1>Receipt from Irrigation</h1>
<p>Thank you for your purchase, {$user['username']}!</p>
<p>Please pickup your delivery from the warehouse showing this email. Here are the details of your order:</p>
<table border='1' cellpadding='10'>
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        $products
    </tbody>
    <tfoot>
        <tr>
            <td colspan='3'>Total Price</td>
            <td>\$$total_price</td>
        </tr>
        <tr>
            <td colspan='3'>Discount</td>
            <td>\$$discount</td>
        </tr>
        <tr>
            <td colspan='3'>Final Amount</td>
            <td>\$$final_amount</td>
        </tr>
    </tfoot>
</table>";


send_mail($user['email'], $message);


$delete_query = "DELETE FROM cart_item WHERE cart_id = ?";
$stmt_delete = $conn->prepare($delete_query);
$stmt_delete->bind_param('i', $cart_id);

if ($stmt_delete->execute()) {
    echo "
    <script type=\"text/javascript\">
        alert('Your order has been placed. Please check your email.');
        window.location.href = 'index.php';
    </script>";
} else {
    echo "<script>alert('Error deleting cart items: " . $stmt_delete->error . "')</script>";
}

?>
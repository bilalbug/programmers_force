<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="advance_form.php" method="post">
        Name: <input type="text" name="name"><br>
        Email: <input type="email" name="email"><br>
        Phone: <input type="phone" name= "phone"><br>
        <input type="Submit">
    </form>
    <?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];  // Use $_POST to retrieve form data
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    echo "Hello, " . $name . "! Your email address (" . $email . ") and phone number (" . $phone . ") have been updated successfully!";
}
?>

</body>
</html>
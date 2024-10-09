<?php
declare(strict_types=1);
session_start();

$provider = []; //arry to store the form data
$errors = []; //arry to store the error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $provider['name'] = trim(strip_tags($_POST['name']));
    $provider['email'] = trim(strip_tags($_POST['email']));
    $provider['cif'] = trim(strip_tags($_POST['cif']));

    $_SESSION['provider'] = $provider;

    $errors = validateProvider($provider);

    if (empty($errors)) {
        header("Location:show_provider.php");
    }

}  //end of POST

function validateProvider(array $provider): array {
    $errors = [];
    if (empty($provider['name'])) {
        $errors['name'] = "* Name is required";
    } elseif (strlen($provider['name']) < 4) {
        $errors['name'] = "* Name must be at least 4 characters long";
    }

    if(empty($provider['email'])) {
        $errors['email'] = "* Email is required";
    } elseif (!filter_var($provider['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "* Invalid email format";
    }

    if(empty($provider['cif'])) {
        $errors['cif'] = "* CIF is required";
    } elseif (!preg_match("/^[A-Z a-z]{1}[0-9]{8}$/", $provider['cif'])) {
        $errors['cif'] = "* Invalid CIF format";
    }

    return $errors;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Providers form sample</title>
    <meta name="author" content="Ricardo Sanchez">
    <meta name="description" content="a sample form to show validation techniques">
    <link rel="stylesheet" type="text/css" href="./main.css">
</head>
<body>
<h1>Provider</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?= $provider['name'] ?? '' ?>">
    <span class="error"> <?= $errors['name'] ?? '' ?> </span> <br><br>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" value="<?= $provider['email'] ?? '' ?>">
    <span class="error"> <?= $errors['email'] ?? '' ?> </span> <br><br>

    <label for="cif">CIF:</label>
    <input type="text" id="cif" name="cif" value="<?= $provider['cif'] ?? '' ?>">
    <span class="error"> <?= $errors['cif'] ?? '' ?> </span><br><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>
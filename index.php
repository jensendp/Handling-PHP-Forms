<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Comment Form</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>

    <?php
        $nameError = $commentError = $emailError = "";

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = htmlspecialchars($_POST["name"]);
            $nameError = validate_required_input($name, "Name", "string");
            $email = htmlspecialchars($_POST["email"]);
            $emailError = validate_input_format($email, "Email", "(^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$)");
            $comments = htmlspecialchars($_POST["comments"]);
            $commentError = validate_required_input($comments, "Comments", "string");
        }

        function validate_required_input($inputValue, $inputName, $expectedType) {
            $error = "";
            $error = $inputValue == "" ? $inputName . " is required" : "";

            if(!empty($error)) {
                return $error;
            }
            
            switch($expectedType) {
                case "integer":
                    $error = !is_numeric($inputValue) ? $inputName . " should be a numeric value" : "";
                    break;
                case "string":
                    $error = !is_string($inputValue) ? $inputName . " should be a string" : "";
                    break;
                default:
                    $error = "";
                    break;
            }
            
            return $error;
        }

        function validate_input_format($inputValue, $inputName, $expectedFormat) {
            return preg_match($expectedFormat, $inputValue) ? "" : $inputName . " was not in the correct format";
        }
    ?>

    <h1>Comments</h1>

    <h2>Please leave a comment below:</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
        Name: <input type="text" name="name" id="name">
        <span class="error">* <?php echo $nameError; ?></span>
        <br><br>
        Email: <input type="text" name="email" id="email">
        <span class="error"><?php echo $emailError; ?></span>
        <br><br>
        Comments: 
        <span class="error">* <?php echo $commentError; ?></span>
        <br>
        <textarea name="comments" id="comments" cols="75" rows="10"></textarea>
        <br><br>
        <input type="submit" value="Submit">
    </form>

    <br><br>

    <h2>Information From Form</h2>
    <?php
        echo "Name: " . $name;
        echo "<br>";
        echo "Email: " . $email;
        echo "<br>";
        echo "Comments: " . $comments;
        echo "<br>";
    ?>
</body>
</html>
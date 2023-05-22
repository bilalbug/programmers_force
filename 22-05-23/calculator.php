<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Calculator</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <form action="calculator.php" method="post">
            First Number:<input type= "number" name="first_number"><br><br>
            Operator:<input type= "text" name="operator"><br><br>
            Second Number:<input type= "number" name="second_number"><br><br>
            <input type="Submit">
        </form>

        <?php
        // checking that if the fields are empty
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $first_number = check_input($_POST["first_number"]);
            $operator = check_input($_POST["operator"]);
            $second_number = check_input($_POST["second_number"]);

            // checking that if the operator is else than (+, -, *, /)
            if($operator=="+" or $operator=="-" or $operator=="*" or $operator=="/")
                {
                    if ($operator == "+"){
                        $result = $first_number+$second_number;
                    }
                    elseif($operator == "-"){
                        $result = $first_number-$second_number;
                    }
                    elseif($operator == "*"){
                        $result = $first_number*$second_number;
                    }
                    elseif($operator == "/"){
                        if($second_number!=0)
                            $result = $first_number/$second_number;
                        else
                            $result = -1;
                    }
                    echo ("<br><br><br>".$first_number.$operator.$second_number."<br>Result = ".$result);

                }

            else{
                $result = 0;
                echo("<br><br><br>Result = ".$result."<br>Please choose a correct operator or fill the fields correctly.");
            }
        }

        function check_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }
        ?>
    </body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Calculator</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            text-align: center;
        }
        .calculator {
            width: 80%;
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input, select, button {
            padding: 10px;
            margin: 5px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }
        #result {
            margin-top: 20px;
            font-size: 20px;
        }
        #history {
            margin-top: 20px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <h1>Responsive Calculator</h1>

        <form method="post" onsubmit="return validateForm()">
            <input type="number" name="num1" placeholder="Enter number 1" required>
            <select name="operator" required>
                <option value="+">+</option>
                <option value="-">-</option>
                <option value="*">*</option>
                <option value="/">/</option>
                <option value="sqrt">?</option>
                <option value="pow">x^y</option>
            </select>
            <input type="number" name="num2" placeholder="Enter number 2" required>
            <button type="submit" name="calculate">Calculate</button>
        </form>

        <?php
        if (isset($_POST['calculate'])) {
            $num1 = $_POST['num1'];
            $num2 = $_POST['num2'];
            $operator = $_POST['operator'];
            $result = 0;

            switch ($operator) {
                case '+':
                    $result = $num1 + $num2;
                    break;
                case '-':
                    $result = $num1 - $num2;
                    break;
                case '*':
                    $result = $num1 * $num2;
                    break;
                case '/':
                    if ($num2 != 0) {
                        $result = $num1 / $num2;
                    } else {
                        echo '<p style="color: red;">Error: Division by zero</p>';
                    }
                    break;
                case 'sqrt':
                    $result = sqrt($num1);
                    break;
                case 'pow':
                    $result = pow($num1, $num2);
                    break;
                default:
                    echo '<p style="color: red;">Invalid operator</p>';
                    break;
            }

            echo '<div id="result"><strong>Result:</strong> ' . $result . '</div>';

            // Store calculation history in session
            session_start();
            if (!isset($_SESSION['history'])) {
                $_SESSION['history'] = [];
            }
            array_push($_SESSION['history'], "$num1 $operator $num2 = $result");
        }
        ?>

        <div id="history">
            <h2>Calculation History</h2>
            <?php
            // Display calculation history
            if (isset($_SESSION['history'])) {
                echo '<ul>';
                foreach ($_SESSION['history'] as $calculation) {
                    echo '<li>' . $calculation . '</li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
    </div>

    <script>
        function validateForm() {
            var num1 = document.forms[0]["num1"].value;
            var num2 = document.forms[0]["num2"].value;
            
            // Validate that num2 is not zero for division operation
            if (document.forms[0]["operator"].value === '/' && num2 == 0) {
                alert("Error: Division by zero is not allowed.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
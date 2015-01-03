<?php
    include 'header.php';

    if (preg_match('/\s/',$_POST['username']))
    {
        echo '<h3> Invalid Username! Cannot have spaces. </h3>';
    }
    elseif (isset($_POST['email']) &&!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
    {
        echo '<h3> Invalid Email format! </h3>';
    }
    elseif(isset($_POST['submit'], $_POST['username'], $_POST['firstname'], 
        $_POST['lastname'], $_POST['email'], $_POST['password']) &&
        $_POST['username'] !== '' && $_POST['firstname'] !== '' && 
        $_POST['lastname'] !=='' && $_POST['email'] !== '' && $_POST['password'] !== '')
    {
        $conn = createConnection();
        $result = registerNewUser($conn, $_POST['username'], $_POST['password'], $_POST['email'], 
            $_POST['firstname'], $_POST['lastname']);
        
        if ($result === -1)
        {
            echo '<h3> User already registered! </h3>';
        }
        else
        {
            if ($result === 0)
            {
                echo '<h3> New record created successfully! </h3>';
            }
            elseif ($result > 0)
            {
                echo '<h3> Error in user registration! </h3>';
            }
            else
            {
                echo '<h3> Unknown error occurred! </h3>';
            }
        }

        closeConnection($conn);
    }
    elseif (isset($_POST['submit']))
    {
        echo '<h3> All fields are mandatory! </h3>';
    }
?>

<!DOCTYPE html>
<html lang="en">
    <body>
        <div class="indent">
            <strong>Register as a new user:</strong>
            <form method="post" action="register.php">
                <table>
                    <tr>
                        <td>
                            <label>First Name: </label>
                        </td>
                        <td>
                            <input type="text" name="firstname" value="<?php if ($result !== 0) echo $_POST['firstname'];?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Last Name: </label>
                        </td>
                        <td>
                            <input type="text" name="lastname" value="<?php if ($result !== 0) echo $_POST['lastname'];?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Username: </label>
                        </td>
                        <td>
                            <input type="text" name="username" value="<?php if ($result !== 0) echo $_POST['username']?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Email: </label>
                        </td>
                        <td>
                            <!-- Replace current validation with regex expression in .js for smoother client-side validation -->
                            <input type="text" name="email" value="<?php if ($result !== 0) echo $_POST['email']?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Password: </label>
                        </td>
                        <td>
                            <input type="password" name="password"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="Submit" name="submit"/>
                        </td>
                    </tr>
                </table>
                <br>
            </form>
        </div>
        
    </body>
</html>

<?php
    include 'header.php';
    
    if(isset($_POST['submit'], $_POST['category'], $_POST['amount']) &&
        $_POST['category'] !== '' && $_POST['amount'] !== '' && is_numeric($_POST['amount']))
    {
        $conn = createConnection();
        $success = updateInventory($conn, $_POST['category'], $_POST['amount']);

        if ($success === TRUE)
        {
            echo '<h3> Inventory successfully updated! </h3>';
        }
        else
        {
            echo '<h3> Error in inventory adjustment! </h3>';
        }

        closeConnection($conn);
    }
    elseif (isset($_POST['amount']) && !is_numeric($_POST['amount']))
    {
        echo '<h3> Incorrect format for amount! </h3>';
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
            <strong>Increase the Inventory for a Category of Products:</strong>
            <form method="post" action="updateinventory.php">
                <table>
                    <tr>
                        <td>
                            <label>Product Category: </label>
                        </td>
                        <td>
                            <input type="text" name="category"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Amount: </label>
                        </td>
                        <td>
                            <input type="text" name="amount"/>
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


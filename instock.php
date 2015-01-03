<?php
    include 'header.php';

    $queryResult = NULL;
    
    if(isset($_POST['submit'], $_POST['name']) &&
        $_POST['name'] !== '')
    {     
        $conn = createConnection();
        
        $queryResult = checkInStock($conn, $_POST['name']);
    }
    elseif (isset($_POST['submit']))
    {
        echo '<h3> You haven\'t selected a product! </h3>';
    }
?>

<div class="indent">
    <h4>Select a Product:</h4>
    <form method="post" action="instock.php">
        <table>
            <tr>
                <td>
                    <label>Product Name: </label>
                </td>
                <td>
                    <input type="text" name="name"/>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="Submit" name="submit"/>
                </td>
            </tr>
        </table>
    </form>
</div>

<?php
    
    if ($queryResult !== NULL)
    {
        echo '<h4> Product found! Here are the available sizes, and how many we have left of each. </h4><br>';

        echo    '<table>'.'<th> Size </th><th> Quantity Remaining </th>';

        $queryResult->bind_result($size, $remaining);

        while ($queryResult->fetch())
        {
            echo '<tr>'.
            '<td><h4>'.$size.'</h3></td>'.
            '<td><h4>'.$remaining.'</h4></td>'.
            '</tr>';
        }

        echo '</table>';

        freeStatement($queryResult);
        closeConnection($conn);
    }
?>

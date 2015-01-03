<?php
    // currently active products that have been viewed by other customers that also viewed the selected product
    // ordered by descending views, with precedence given to featured products
    include 'header.php';

    $queryResult = NULL;
    
    if(isset($_POST['submit'], $_POST['name']) &&
        $_POST['name'] !== '')
    {   
        $conn = createConnection();
        $queryResult = relatedProducts($conn, $_POST['name']);
    }
    elseif (isset($_POST['submit']))
    {
        echo '<h3> You haven\'t selected a product! </h3>';
    }
    
    
?>

<div class="indent">
    <h4>Select a Product:</h4>
    <form method="post" action="related.php">
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
        $queryResult->bind_result($name, $category, $price, $notes);
        echo '<h4> Product successfully selected! Below are other products that people who viewed this product also viewed. </h4><br>';

        echo    '<table>'.'<th> Name </th><th> Category </th><th> Price ($) </th><th> Additional Notes </th>';

        while ($queryResult->fetch())
        {
            echo '<tr>'.
            '<td><h4>'.$name.'</h3></td>'.
            '<td><i>'.$category.'</i></td>'.
            '<td>'.$price.'</td>'.
            '<td>'.$notes.'</td>'.
            '</tr>';
        }

        echo '</table>';

        freeStatement($queryResult);
        closeConnection($conn);
    }
?>

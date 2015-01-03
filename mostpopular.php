<?php
    include 'header.php';

    $queryResult = NULL;
    
    if(isset($_POST['submit'], $_POST['size']) &&
        $_POST['size'] !== '')
    {   
        $conn = createConnection();
        $queryResult = getMostPopular($conn, $_POST['size']);
    }
    elseif (isset($_POST['submit']))
    {
        echo '<h3> You must select a size! </h3>';
    }
    
    
?>

<div class="indent">
    <strong>Most Popular Clothing Items in Your Size:</strong>
    <form method="post" action="mostpopular.php">
        <label>Garment size: </label>
        <select name="size">
            <option value="">Select...</option>
            <option value="XS">XS</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
            <option value="2XL">2XL</option>
            <option value="3XL">3XL</option>
        </select>
        <br>
        <input type="submit" value="Submit" name="submit">
    </form>
</div>

<?php
    
    if ($queryResult !== NULL)
    {
        $queryResult->bind_result($name, $category, $price, $size, $colour, $quantitySold);
        echo '<h3> Size successfully chosen! </h3><br>';

        echo    '<table>'.'<th> Name </th><th> Category </th><th> Price ($) </th><th> Size </th><th> Colour </th>'.
        '<th> Quantity Sold </th>';

        while ($queryResult->fetch())
        {
            echo '<tr>'.
            '<td><h4>'. $name .'</h3></td>'.
            '<td><i>'. $category .'</i></td>'.
            '<td>'. $price .'</td>'.
            '<td>'. $size.'</td>'.
            '<td>'. $colour.'</td>'.
            '<td>'. $quantitySold.'</td>'.
            '</tr>';
        }
        echo '</table>';

        freeStatement($queryResult);
        closeConnection($conn);
    }
?>
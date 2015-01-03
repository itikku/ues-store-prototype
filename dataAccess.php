<?php

function selectData($query)
{
    $conn = createConnection();
    $result = $conn->query($query);
    closeConnection($conn);
    return $result;
}

function updateData($query)
{
    $conn = createConnection();
    $result = $conn->query($query);
    closeConnection($conn);
    return $result;
}

function insertData($query)
{
    $conn = createConnection();
    $result = $conn->query($query);
    closeConnection($conn);
    return $result;
}

function deleteData($query)
{
    $conn = createConnection();
    $result = $conn->query($query);
    closeConnection($conn);
    return $result;
}

function registerNewUser($conn, $username, $password, $email, $firstname, $lastname)
{   
    if (checkExistingUser($conn, $username) !== TRUE)
    {
        return -1;
    }

    $newID = generateNewID($conn);
    
    $statement = $conn->prepare("INSERT INTO shopper (userID, username, pword, email, firstname, lastname) VALUES " .
        "(?, ?, ?, ?, ?, ?)");

    // ideally we'd like to hash the password, but we were in a bit of time crunch...
    $statement->bind_param('isssss', $newID, $username, $password, $email, $firstname, $lastname);
    $return = $statement->execute();
    $statement->free_result();

    if ($return === TRUE)
        return 0;
    else
        return 1;
}

function checkExistingUser($conn, $username)
{
    $statement = $conn->prepare("SELECT * FROM shopper WHERE username = ?");
    $statement->bind_param('s', $username);
    $statement->execute();
    
    while($statement->fetch())
    {
        return FALSE;
    }

    return TRUE;
}

// This function is an awful hack that was the result of an error in creating our database schema (which we didn't have time to fix).
// All it does is get the highest numeric userID and adds 1 to get a new userID. 
function generateNewID($conn)
{
    $query = "SELECT MAX(userID) as maxID FROM shopper";
    $result = $conn->query($query);
    $newID = NULL;

    while ($row = $result->fetch_assoc())
    {
        $newID = $row["maxID"] + 1;
    }

    return $newID;
}

function getMostPopular($conn, $size)
{

    $query ='SELECT productLineName, category, price, size, colour, quantitySold FROM item i '.
            'INNER JOIN clothingitem c ON c.SKU = i.SKU '.
            'INNER JOIN productline p on p.name = i.productLineName '.
            'WHERE p.isActiveForSale = 1 '.
            'AND c.size = ? '.
            'ORDER BY quantitySold DESC;';

    $statement = $conn->prepare($query);
    $statement->bind_param('s', $size);
    $return = $statement->execute();
    if ($return === TRUE)
        return $statement;
    else
        return NULL;
}

function updateInventory($conn, $category, $amount)
{
    $query = 'UPDATE item im JOIN productline p ON p.name = im.productLineName ' .
            'SET im.quantityRemaining = im.quantityRemaining + ? ' .
            'WHERE p.category = ?;';

    $statement = $conn->prepare($query);
    $statement->bind_param('is', $amount, $category);
    $success = $statement->execute();
    $statement->free_result();

    return ($success == 1);
}

function relatedProducts($conn, $name)
{
    $query = 'SELECT w.name, p.category, p.price, p.additionalNotes FROM viewsproduct w
            INNER JOIN productline p ON p.name = w.name
            WHERE w.userID IN (SELECT v.userID FROM viewsproduct v
            WHERE v.name = ?)
            AND w.name <> ?
            AND p.isActiveForSale = 1
            GROUP BY w.name
            ORDER BY isFeatured DESC, w.timesViewed DESC;';

    $statement = $conn->prepare($query);
    $statement->bind_param('ss', $name, $name);
    $return = $statement->execute();
    print_r($return);
    if ($return === TRUE)
        return $statement;
    else
        return NULL;
}

function checkInStock($conn, $name)
{
    $query = 'SELECT n.size, i.quantityRemaining  FROM item i 
            INNER JOIN productline p ON p.name = i.productLineName
            INNER JOIN clothingitem n ON n.SKU = i.SKU 
            WHERE p.name = ?';

    $statement = $conn->prepare($query);
    $statement->bind_param('s', $name);
    $result = $statement->execute();

    if ($result === TRUE)
        return $statement;
    else
        return NULL;
}

function createConnection()
{
    // specify database connection
    $servername = "localhost";
    $username = "root";
    $password = "@Billytikky88";
    $dbname = "plusminusstore";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn; 
}

function freeStatement($statement)
{
    $statement->free_result();
}

function closeConnection($connection)
{
    $connection->close();
}
?>

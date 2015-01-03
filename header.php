<?php
    include 'dataAccess.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="main.css" />
        <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" />
        <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" />
        <meta charset="utf-8" />
        <title>
            UES Store
        </title>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-default">
              <div class="container">
                <div class="navbar-header">
                  <a class="navbar-brand" href="/">
                    UES Store
                  </a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                  <li>
                    <a href="/register.php"><i class="fa fa-user"></i> Register 
                    </a>
                  </li>
                  <li>
                    <a href="/mostpopular.php"><i class="fa fa-thumbs-up"></i> Most Popular Items</a>
                  </li>
                    <li>
                    <a href="/instock.php"><i class="fa fa-dollar"></i> Check our Inventory</a>
                    </li>
                    <li>
                    <a href="/updateinventory.php"><i class="fa fa-beer"></i> Change Product Inventory</a>
                    </li>
                    <li>
                    <a href="/related.php"><i class="fa fa-usd"></i> Related Products for You</a>
                    </li>
                    <li>
                    <a href="/"><i class="fa fa-home"></i> Quit</a>
                    </li>
                </ul>
              </div>
            </nav>
          </header>
        
    </body>
</html>

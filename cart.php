<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/reset.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <link rel="shortcut icon" href="img/cart.png" type="image/x-icon">
    <title>Cart</title>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark navbar-expand-md">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php" style="font-family: 'Permanent Marker', cursive; font-size: 23px;">
                <img src="img/shopping-bag.png" alt="cart" width="34" height="34" class="rounded-pill">
                Shopping Cart
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Products</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Categories</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Checkout</a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" href="cart.php"><i class="fas fa-shopping-cart"></i>
                <span id="cart-item" class="badge bg-danger"></span></a>
                </li>
            <?php
                if (isset($_SESSION["userId"])) {
                echo "<li class='nav-item'><a class='nav-link' aria-current='page' href='profile.php'>Profile page</a></li>";
                echo "<li class='nav-item'><a class='nav-link' aria-current='page' href='includes/logout.inc.php'>Log out</a></li>";
                } else {
                echo "<li class='nav-item'><a class='nav-link' aria-current='page' href='signup.php'>Sign up</a></li>";
                echo "<li class='nav-item'><a class='nav-link' aria-current='page' href='login.php'>Log in</a></li>";
                }
            ?>
            </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="table-responsive mt-2">
                    <table class="table table-bordered table-striped text-center">
                       <thead>
                            <tr>
                                <td colspan="7">
                                    <h4 class="text-center text-info m-0 ">
                                        Product in your cart!
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th> 
                                    <a href="action.php?clear=all" 
                                        onclick="return confirm('Are you sure want to clear your cart?');">
                                        <span class="badge text-bg-danger p-2"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</span>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require 'includes/dbh.inc.php';
                                $stmt = $conn->prepare("SELECT * FROM cart");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $grand_total = 0;
                                while($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><img src="<?= $row['product_image'] ?>" width="50"></td>
                                <td><?= $row['product_name'] ?></td>
                                <td><i class="fas fa-dollar-sign">&nbsp;&nbsp;<?= number_format($row['product_price'], 2)?></i></td>
                                <td><input type="number" class="form-control itemQty" value="<?= $row['qty'] ?>" style="width:75px;"></td>
                                <td></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
           
            // Load total no.of items added in the cart and display in the navbar
            load_cart_item_number();

            function load_cart_item_number() {
            $.ajax({
                url: 'action.php',
                method: 'get',
                data: {cartItem:"cart_item"},
                success: function(response){
                $("#cart-item").html(response);
                }
            });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" 
            crossorigin="anonymous">
    </script>

</body>
</html>

<script src="js/app.js"></script>
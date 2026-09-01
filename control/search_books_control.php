<?php

include("../model/db.php");

$mydb = new mydb();

$conobj = $mydb->openConn();


if(isset($_GET["search"])){

    $search=$_GET["search"];
    $filter=$_GET["filter"];

    $result=$mydb->searchBooks($conobj,$search,$filter);

    if($result->num_rows>0){

        while($row=$result->fetch_assoc()){

?>

<div class="book-card">

    <img src="../<?php echo $row["image_path"]; ?>">

    <h3>
        <?php echo htmlspecialchars($row["title"]); ?>
    </h3>

    <p class="author">
        By <?php echo htmlspecialchars($row["author"]); ?>
    </p>

    <p class="category">
        <?php echo htmlspecialchars($row["category_name"]); ?>
    </p>

    <p class="price">
        ৳<?php echo $row["price"]; ?>
    </p>

    <p class="stock">

        <?php

        if($row["stock"]>0){

            echo "In Stock";

        }
        else{
            echo "Out of Stock";
        }

        ?>
    </p>

    <a href="book_details.php?id=<?php echo $row["id"]; ?>"
       class="details-btn">

        Details

    </a>

</div>

<?php
        }

    }

    else{
        echo "<h2>No books found</h2>";
    }

}

?>
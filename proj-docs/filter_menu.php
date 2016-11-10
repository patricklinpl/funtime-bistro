<?php

if(isset($_POST['sort']))
{

    $col = $_POST['filter'];

    if ($col == "")

    $num = $_POST['value'];
    $operator = $_POST['operator'];


    if ($_POST['operator'] == "eq") {
        $operator = '=';
    }

    if ($_POST['operator'] == "gt") {
        $operator = '>';
    }

    if ($_POST['operator'] == "lt") {
        $operator = '<';
    }


    $query = "SELECT name, price, imagepath, description, qty 
    FROM MenuItem 
    WHERE $col $operator $num";

    if ($query) {
         $search_result = filterTable($query);
    } 
}
else {
    $query = "SELECT name, price, imagepath, description, qty FROM MenuItem  WHERE m_deleted = 'F'";
    $search_result = filterTable($query);
}

// function to connect and execute the query
function filterTable($query)
{
    $connect = mysqli_connect("localhost", "root", "patricklin", "funtime");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Funtime Restaurant</title>
    <style>
        table,tr,th,td
        {
            border: 1px solid black;
        }
    </style>
    <p> <font size = "20" color = maroon >  Fun Time Bistro Menu</font></p>
</head>
<body>

    <form method="post">
        Show only Menu Items where

        <select name="filter">
            <option value="price">Price</option>
            <option value="quantity">Quantity</option>
        </select>

        is

        <select name="operator">
            <option value="eq">=</option>
            <option value="gt">></option>
            <option value="lt"><</option>
        </select>

        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Description</th>
                <th>Quantity</th>
            </tr>

            <input type="number" name="value" min=0 required>

            <input type="hidden" name="sort">

            &nbsp;

            <input type="submit" value="Filter"> 

            &nbsp; &nbsp;

            or 

            &nbsp; &nbsp;

            <a href="test.php"> Show All Menu Items <a/>

            </form>
            <br/><br/>

            <!-- populate table from mysql database -->
            <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td><?php echo $row['name'];?></td>
                    <td><?php echo $row['price'];?></td>
                    <td><?php echo $row['imagepath'];?></td>
                    <td><?php echo $row['description'];?></td>
                    <td><?php echo $row['qty'];?></td>
                </tr>
            <?php endwhile;?>
        </table>
    </form>

</body>
</html>
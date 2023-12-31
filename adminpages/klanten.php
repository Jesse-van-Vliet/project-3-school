<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="../">
    <link rel="stylesheet" href="style.css">
    <title>Klanten inzien - Brouwerskazen</title>
</head>

<body>
    <header class="main-head">
        <!-- nav bar -->
        <?php
        include '../includes/nav.html';
        require '../includes/connDatabase.php'
            ?>
    </header>


    <main class="bg">
        <div class="about-mk">
            <div class="about-mk-title">
                <h1>Klanten inzien</h1>
                <p>Op deze pagina kunt u de informatie over onze klanten inzien.</p>

            </div>
            <img class="about-mk-pic" src="./img/mederwerker.png" alt="">
        </div>

        <section class="country-stuff small-margin">
            <form class="see-form" method="POST" action="">
                <div>
                    <input placeholder="Filteren op woonplaats van klant" type="text" name="place" id="name">
                </div>
                <!-- <input class="submitbtn" type="submit" value="Filter Gegevens"> -->
            </form>
            <table>
                <caption>Categorien</caption>
                <tr>
                    <th>KlantID</th>
                    <th>Voornaam</th>
                    <th>Achternaam</th>
                    <th>Email</th>
                    <th>Land</th>
                    <th>Provincie</th>
                    <th>Stad</th>
                    <th>Adress</th>
                    <th>Postcode</th>
                    <th>TelefoonNR</th>
                    <th>D.O.B.</th>
                </tr>
                <?php
                // Checks if the filter is NOT set
                if (!isset($_POST["place"]) || $_POST["place"] === "*") {
                    try {
                        // Prepares a query for retrieving all data from the customers table, and executes it
                        $query = $db->prepare("
                        SELECT * FROM customers
                        ");
                        $query->execute();
                    } catch (PDOException $e) {
                        // Catch any errors
                        exit($e->getMessage());
                    }
                } else {
                    // If the form is not set, retrieve the "place" from the form
                    $place = $_POST["place"];
                    // Prepares a query that selects everything from the custoemrs table where the city is like city
                    // Then executes that query with $place as the LIKE clause
                    try {
                        $query = $db->prepare("
                        SELECT *
                        FROM customers
                        WHERE city LIKE :city
                        ");
                        $query->execute([":city" => '%' . $place . '%']);
                    } catch (PDOException $e) {
                        // Catch any errors
                        exit($e->getMessage());
                    }
                }

                // Retrieves all customers from the database
                $customers = $query->fetchAll();
                
                // Echoes the results as a table
                foreach ($customers as $customer) {
                    echo '<tr>';
                    echo '<td>' . $customer["customerid"] . '</td>';
                    echo '<td>' . $customer["firstname"] . '</td>';
                    echo '<td>' . $customer["lastname"] . '</td>';
                    echo '<td>' . $customer["email"] . '</td>';
                    echo '<td>' . $customer["country"] . '</td>';
                    echo '<td>' . $customer["province"] . '</td>';
                    echo '<td>' . $customer["city"] . '</td>';
                    echo '<td>' . $customer["adress"] . '</td>';
                    echo '<td>' . $customer["zipcode"] . '</td>';
                    echo '<td>' . $customer["phonenumber"] . '</td>';
                    echo '<td>' . $customer["birthday"] . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>

        </section>
    </main>

    <?php include '../includes/footer.html' ?>
</body>

</html>
<?php
$dbServerName = 'programmation-web-3.org';
$dbUserName = 'root';
$dbPassword = '';
$dbName = 'programmationweb3';
$mysqli = mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName);

if (mysqli_connect_errno()) {
    echo 'Erreur de connection au serveur MySQL: ('.$mysqli->connect_errno.') '.$mysqli->connect_error;
    exit;
}
$sql = 'select * from ep_product';

// Spécifier l'encodage par défaut pour tous les accès à la base de données
mysqli_set_charset($mysqli, 'utf8');
$result = mysqli_query($mysqli, $sql);

if (!$result) {
    $error = mysqli_error($mysqli);
    var_dump($error);
}

$listeProduits = [];
while ($produit = mysqli_fetch_assoc($result)) {
    array_push($listeProduits, $produit);
}

mysqli_close($mysqli);

$fields = [
'productName' => ['order' => '', 'label' => 'Nom'],
'productCode' => ['order' => '', 'label' => 'Code'],
'productPrice' => ['order' => '', 'label' => 'Prix'],
'productDescription' => ['order' => '', 'label' => 'Description'],
'discontinue' => ['order' => '', 'label' => 'Discontinue'],
'inventoryCount' => ['order' => '', 'label' => 'Inventaire'],
'releaseDate' => ['order' => '', 'label' => 'Date de distribution'],
];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .order-asc::after {
            content: "↓";
        }

        .order-desc::after {
            content: "↑";
        }

        thead th {
            position: sticky;
            top: 0;
        }

        .product-discontinue {
            background-color: red;
        }

        .product-over-100 {
            border: 3px solid blue;
        }

        .product-current-year {
            font-weight: bold;
        }
    </style>
    <title>Examen pratique</title>
</head>

<body>
    <div class="container">

        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <?php foreach ($fields as $item): ?>
                    <th><a name="<?=$item['label']; ?>"
                            href="#"><?=$item['label']; ?></a>
                    </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listeProduits as $produit): ?>
                <tr class="<?php if ($produit['discontinue'] > 0) {
    echo 'product-discontinue';
} elseif ($produit['productPrice'] > 100) {
    echo 'product-over-100';
} elseif ($produit['discontinue'] > 0 && $produit['productPrice'] > 100) {
    echo 'product-discontinue';
    echo  'product-over-100';
} elseif ($produit['releaseDate'] >= 2019) {
    echo 'product-current-year';
}
                    ?>">
                    <td>
                        <?= $produit['productName']; ?>
                    </td>
                    <td>
                        <?= $produit['productCode']; ?>
                    </td>
                    <td>
                        <?= $produit['productPrice']; ?>
                    </td>
                    <td>
                        <?= $produit['productDescription']; ?>
                    </td>
                    <td>
                        <?= $produit['discontinue']; ?>
                    </td>
                    <td>
                        <?= $produit['inventoryCount']; ?>
                    </td>
                    <td>
                        <?= $produit['releaseDate']; ?>
                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>

</html>
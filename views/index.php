<?php

require 'partials/head.php';
require 'partials/header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>fwbnfoewbnfoboboe</p>
</body>
<main>
    <div class="tab-content">
        <div class='tab-pane active' id='tab1' role='tabpanel'>
            <div class="table-container" style="width: 80%; display: block; margin: auto;"> <!-- doit mettre styles marche pas si on met dans la classe wtf-->
                <table class="table">
                    <tr>
                        <?php for ($i = 0; $i < 10; $i++) { ?>
                            <td>
                                <div class="img-thumbnail">
                                    <img src="https://sm.ign.com/ign_nordic/news/u/us-senator/us-senator-writes-to-valve-boss-gabe-newell-demanding-crackd_zq2z.jpg" class="img-fluid">
                                    <div class="price">10.99 $</div>
                                    <div class="caption">
                                        <h4>Gaben</h4>
                                        <form method="POST">
                                            <input type="hidden" name="idItem" value="1">
                                            <input type="hidden" name="name" value="Sample Sushi">
                                            <input type="hidden" name="description" value="Delicious sushi description.">
                                            <input type="hidden" name="prixItem" value="10.99">
                                            <input type="hidden" name="image" value="sample.jpg">
                                            <button type="submit" class="btn btn-order add-to-cart" name="ajouter">
                                                <span class="bi-cart-fill"></span> Ajouter au panier
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <?php if (($i + 1) % 3 == 0) { echo "</tr><tr>"; } ?>
                        <?php } ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</main>
<?php require 'partials/footer.php'; ?>
</html>
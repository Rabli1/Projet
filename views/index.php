<?php

require 'partials/head.php';
require 'partials/header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knapsack</title>
</head>
<main>
    <form method="POST" class="center-form"><!-- interfere peut etre avec l'autre post watchout vro-->
        <div class="table-container" style="width: 80%; display: block; margin: auto;">
            <input type="checkbox" id="filtre1" name="filtre1">
            <label for="filtre1">Filtre 1</label>
            <input type="checkbox" id="filtre2" name="filtre2">
            <label for="filtre2">Filtre 2</label>
            <input type="checkbox" id="filtre3" name="filtre3">
            <label for="filtre3">Filtre 3</label>
            <input type="checkbox" id="filtre4" name="filtre4">
            <label for="filtre4">Filtre 4</label>
        </div>
        <input type="text"id="search" name="search" placeholder="Rechercher un item"><br>
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <div class="tab-content">
        <div class='tab-pane active' id='tab1' role='tabpanel'>
            <div class="table-container" style="width: 80%; display: block; margin: auto;"> <!-- doit mettre styles marche pas si on met dans la classe wtf-->
                <table class="table">
                    <tr>
                        <?php $nbParLigne = 1;
                        foreach ($items as $index => $item) { ?>
                            <td>
                                <div class="img-thumbnail">
                                    <img src="public/img/<?=$item->getPhoto()?>" class="img-fluid">
                                    <h4><?=$item->getNomItem()?></h4>
                                    <div class="price"><?=$item->getPrixItem()?> Capsules</div>
                                    <div class="caption">
                                        <p><?=$item->getPoidsItem()?> lbs</p>
                                        <form method="POST"><!-- interfere peut etre avec l'autre post watchout vro-->
                                            <input type="hidden" name="idItem" value="<?=$item->getIdItem()?>">
                                            <input type="hidden" name="name" value="<?=$item->getNomItem()?>">
                                            <input type="hidden" name="prixItem" value="<?=$item->getPrixItem()?>">
                                            <input type="hidden" name="image" value="<?=$item->getPhoto()?>">
                                            <button type="submit" class="btn btn-order add-to-cart" name="ajouter">
                                                <span class="bi-cart-fill"></span> Ajouter au panier
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <?php if ($nbParLigne % 3 == 0) { 
                                echo "</tr><tr>"; 
                                $nbParLigne = 1;
                            }
                            else {
                                $nbParLigne++;
                            } ?>
                        <?php } ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</main>
<?php require 'partials/footer.php'; ?>
</html>
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
        <div class="checkbox-container">
        <input type="checkbox" id="arme" name="arme">
            <label for="arme">Armes</label>
            <input type="checkbox" id="munition" name="munition">
            <label for="munition">Munitions</label>
            <input type="checkbox" id="armure" name="armure">
            <label for="armure">Armures</label>
            <input type="checkbox" id="medicament" name="medicament">
            <label for="medicament">Médicaments</label>
            <input type="checkbox" id="nourriture" name="nourriture">
            <label for="nourriture">Nourritures</label>
        </div>
        <input type="text" id="search" name="search" placeholder="Rechercher un item"><br>
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <div class="tab-content">
        <div class='tab-pane active' id='tab1' role='tabpanel'>
            <div class="table-container">
                <table class="table">
                    <tr>
                        <?php $nbParLigne = 1;
                        foreach ($items as $index => $item) { ?>
                            <td>
                                <div class="img-thumbnail">
                                    <div class="price"><?=$item->getPrixItem()?> Capsules</div>
                                    <div class="quantity"><?=$item->getQteStock()?> en stock</div>
                                    <img src="public/img/<?=$item->getPhoto()?>" class="img-fluid">
                                    <h4><?=$item->getNomItem()?></h4>
                                    <div><?=getTypeItemName($item->getTypeItem())?></div>
                                    <div>Utilité : <?=$item->getUtilite()?></div>
                                    <div class="caption">
                                        <div class="weight"><?=$item->getPoidsItem()?> lbs</div>
                                        <form method="POST"><!-- interfere peut etre avec l'autre post watchout vro-->
                                            <input type="hidden" name="idItem" value="<?=$item->getIdItem()?>">
                                            <input type="hidden" name="name" value="<?=$item->getNomItem()?>">
                                            <input type="hidden" name="prixItem" value="<?=$item->getPrixItem()?>">
                                            <input type="hidden" name="image" value="<?=$item->getPhoto()?>">
                                            <input type="hidden" name="typeItem" value="<?=$item->getTypeItem()?>">
                                            <input type="hidden" name="utilite" value="<?=$item->getUtilite()?>">

                                            <button type="submit" class="btn btn-order add-to-cart" name="add_to_cart">
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
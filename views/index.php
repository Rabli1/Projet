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
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<main>
    <form method="POST" class="center-form">
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
        <button type="submit" class="btn btn-primary" name="search_button">Rechercher</button>
    </form>

    <div class="tab-content">
        <div class='tab-pane active' id='tab1' role='tabpanel'>
            <div class="table-container">
                <table class="table" style="width: 100%;">
                    <tr>
                        <?php $nbParLigne = 1;
                        foreach ($items as $index => $item) { ?>
                            <td>
                                <div class="img-thumbnail">
                                    <div class="price price-container"><?=$item->getPrixItem()?><img class="price-container" src="public/img/caps.png" alt="caps" style="max-width: 16px"></div>
                                    <div class="quantity"><?=$item->getQteStock()?> en stock</div>
                                    <img src="public/img/<?=$item->getPhoto()?>" class="img-fluid">
                                    <h4><?=$item->getNomItem()?></h4>
                                    <div><?=getTypeItemName($item->getTypeItem())?></div>
                                    <div>Utilité : <?=$item->getUtilite()?></div>
                                    <div class="caption">
                                        <div class="weight price-container"><?=$item->getPoidsItem()?> lbs<img src="public/img/weight.webp" alt="lbs" class="price-container" style="max-width: 16px"></div>
                                        <?php
                                        switch ($item->getTypeItem()) {
                                            case 'r':
                                                $armure = $armuresModel->selectById($item->getIdItem());
                                                if ($armure) {
                                                    echo "<div>Matière : " . $armure->getMatière() . "</div>";
                                                    echo "<div>Taille : " . $armure->getTaille() . "</div>";
                                                }
                                                break;
                                            case 'a':
                                                $arme = $armesModel->selectById($item->getIdItem());
                                                if ($arme) {
                                                    echo "<div>Efficacité : " . $arme->getEfficacité() . "</div>";
                                                    echo "<div>Type : " . $arme->getTypeArmes() . "</div>";
                                                    echo "<div>Description : " . $arme->getDescription() . "</div>";
                                                    echo "<div>Calibre : " . $arme->getCalibre() . "</div>";
                                                }
                                                break;
                                            case 'm':
                                                $medicament = $medicamentsModel->selectById($item->getIdItem());
                                                if ($medicament) {
                                                    echo "<div>Durée Effet : " . $medicament->getDuréeEffet() . "</div>";
                                                    echo "<div>Effet Indésirable : " . $medicament->getEffetIndésirable() . "</div>";
                                                    echo "<div>Points de Vie : " . $medicament->getPtsVie() . "</div>";
                                                    echo "<div>Effet : " . $medicament->getEffet() . "</div>";
                                                }
                                                break;
                                            case 'n':
                                                $nourriture = $nourrituresModel->selectById($item->getIdItem());
                                                if ($nourriture) {
                                                    echo "<div>Apport Calorique : " . $nourriture->getApportCalorique() . "</div>";
                                                    echo "<div>Composant Nutritif : " . $nourriture->getComposantNutritif() . "</div>";
                                                    echo "<div>Minéral Principal : " . $nourriture->getMineralPrincipal() . "</div>";
                                                    echo "<div>Points de Vie : " . $nourriture->getPtsVie() . "</div>";
                                                }
                                                break;
                                            case 'u':
                                                $munition = $munitionsModel->selectById($item->getIdItem());
                                                if ($munition) {
                                                    echo "<div>Calibre : " . $munition->getCalibre() . "</div>";
                                                }
                                                break;
                                        }
                                        ?>
                                        <form method="POST">
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
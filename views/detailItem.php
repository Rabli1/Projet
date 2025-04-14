<?php
require 'partials/head.php';
require 'partials/header.php';
?>

    <div class="table-container" style="padding-left: 25%;">
        <table class="table" style="width: 100%;">
            <tr>
                <td>

                    <div class="img-thumbnail" style="padding-bottom: 50px;">
                        <div class="price price-container">
                            <?= htmlspecialchars($item->getPrixItem()) ?>
                            <img class="price-container" src="public/img/caps.png" alt="caps" style="max-width: 16px">
                        </div>
                        <div class="quantity <?= $item->getQteStock() <= 0 ? 'stockZero' : '' ?>">
                            <?= htmlspecialchars($item->getQteStock()) ?> en stock
                        </div>
                        <h4><?= htmlspecialchars($item->getNomItem()) ?></h4>
                        <img src="public/img/<?= htmlspecialchars($item->getPhoto()) ?>" class="img-fluid" alt="<?= htmlspecialchars($item->getNomItem()) ?>">
                        <div><strong><?= getTypeItemName($item->getTypeItem()) ?></strong></div>
                        <div><strong>Utilité :</strong> <?= htmlspecialchars($item->getUtilite()) ?></div>
                        <div class="caption">
                            <div class="weight price-container">
                                <?= htmlspecialchars($item->getPoidsItem()) ?> lbs
                                <img src="public/img/weight.webp" alt="lbs" class="price-container" style="max-width: 16px">
                            </div>
                            <?php
                            switch ($item->getTypeItem()) {
                                case 'r':
                                    $armure = $armuresModel->selectById($idItem);
                                    if ($armure) {
                                        echo "<div><strong>Matière :</strong> " . htmlspecialchars($armure->getMatière()) . "</div>";
                                        echo "<div><strong>Taille :</strong> " . htmlspecialchars($armure->getTaille()) . "</div>";
                                    }
                                    break;
                                case 'a':
                                    $arme = $armesModel->selectById($idItem);
                                    if ($arme) {
                                        echo "<div><strong>Efficacité :</strong> " . htmlspecialchars($arme->getEfficacité()) . "</div>";
                                        echo "<div><strong>Type :</strong> " . htmlspecialchars($arme->getTypeArmes()) . "</div>";
                                        echo "<div class='reduce-size'><strong>Description :</strong> " . htmlspecialchars($arme->getDescription()) . "</div>";
                                        echo "<div><strong>Calibre :</strong> " . htmlspecialchars($arme->getCalibre()) . "</div>";
                                    }
                                    break;
                                case 'm':
                                    $medicament = $medicamentsModel->selectById($idItem);
                                    if ($medicament) {
                                        echo "<div><strong>Durée Effet :</strong> " . htmlspecialchars($medicament->getDuréeEffet()) . "</div>";
                                        echo "<div class='reduce-size'><strong>Effet Indésirable :</strong> " . htmlspecialchars($medicament->getEffetIndésirable()) . "</div>";
                                        echo "<div><strong>Points de Vie :</strong> " . htmlspecialchars($medicament->getPtsVie()) . "</div>";
                                        echo "<div class='reduce-size'><strong>Effet :</strong> " . htmlspecialchars($medicament->getEffet()) . "</div>";
                                    }
                                    break;
                                case 'n':
                                    $nourriture = $nourrituresModel->selectById($idItem);
                                    if ($nourriture) {
                                        echo "<div><strong>Apport Calorique :</strong> " . htmlspecialchars($nourriture->getApportCalorique()) . "</div>";
                                        echo "<div><strong>Composant Nutritif :</strong> " . htmlspecialchars($nourriture->getComposantNutritif()) . "</div>";
                                        echo "<div><strong>Minéral Principal :</strong> " . htmlspecialchars($nourriture->getMineralPrincipal()) . "</div>";
                                        echo "<div><strong>Points de Vie :</strong> " . htmlspecialchars($nourriture->getPtsVie()) . "</div>";
                                    }
                                    break;
                                case 'u':
                                    $munition = $munitionsModel->selectById($idItem);
                                    if ($munition) {
                                        echo "<div><strong>Calibre :</strong> " . htmlspecialchars($munition->getCalibre()) . "</div>";
                                    }
                                    break;
                            }
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</main>
<?php require 'partials/footer.php'; ?>
</body>
</html>
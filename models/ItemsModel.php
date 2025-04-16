<?php

require_once 'src/class/Items.php';

class ItemsModel
{

    // La propriété pourrait être déclarée hors constructeur
    // private PDO $pdo

    // Ici la propriété $pdo est déclarée dans le constructeur directement
    public function __construct(private PDO $pdo) {}
    
    public function selectAllItems() : null|array {

        try{

            // $this->pdo-> car $pdo est une propriété de l'objet
            $stm = $this->pdo->prepare('SELECT * FROM items ORDER BY prixItem DESC, poidsItem DESC');

            $stm->execute();

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($data)) {

                foreach ($data as $row) {

                    $items[] = new Items(
                        $row['idItem'], 
                        $row['nomItem'], 
                        $row['qteStock'], 
                        $row['typeItem'], 
                        $row['prixItem'],
                        $row['poidsItem'],
                        $row['utilité'],
                        $row['photo'],
                        $row['flagDispo']
                        );
                }
                
                return $items;

            }
            
            return null;
            
        } catch (PDOException $e) {
    
            throw new PDOException($e->getMessage(), $e->getCode());
            
        }

    }

    public function selectItemsByTypes($types) {
        try{
            $typesToGet = implode(',', array_fill(0, count($types), '?'));
            $stm = $this->pdo->prepare("SELECT * FROM items WHERE typeItem IN ($typesToGet)");
            $stm->execute($types);

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($data)) {

                foreach ($data as $row) {

                    $items[] = new Items(
                        $row['idItem'], 
                        $row['nomItem'], 
                        $row['qteStock'], 
                        $row['typeItem'], 
                        $row['prixItem'],
                        $row['poidsItem'],
                        $row['utilité'],
                        $row['photo'],
                        $row['flagDispo']
                        );
                }
                
                return $items;

            }
            
            return null;
            
        } catch (PDOException $e) {
    
            throw new PDOException($e->getMessage(), $e->getCode());
            
        }

        
    }
    public function selectById(int $id): ?Items {
        $stmt = $this->pdo->prepare('SELECT * FROM items WHERE idItem = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Items(
                $row['idItem'],
                $row['nomItem'],
                $row['qteStock'],
                $row['typeItem'],
                $row['prixItem'],
                $row['poidsItem'],
                $row['utilité'],
                $row['photo'],
                $row['flagDispo']
            );
        }

        return null;
    }

    public function selectItemsByName(string $nomItem) {
        try{

            // $this->pdo-> car $pdo est une propriété de l'objet
            $stm = $this->pdo->prepare("SELECT * FROM items where nomItem like :nomItem");

            $stm->execute(['nomItem' => '%' . $nomItem . '%']);

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($data)) {

                foreach ($data as $row) {

                    $items[] = new Items(
                        $row['idItem'], 
                        $row['nomItem'], 
                        $row['qteStock'], 
                        $row['typeItem'], 
                        $row['prixItem'],
                        $row['poidsItem'],
                        $row['utilité'],
                        $row['photo'],
                        $row['flagDispo']
                        );
                }
                
                return $items;

            }
            
            return null;
            
        } catch (PDOException $e) {
    
            throw new PDOException($e->getMessage(), $e->getCode());
            
        }

    }

    public function selectByNameAndTypes(array $types, ?string $nomItem): ?array {
        try {
            $typesToGet = implode(',', array_fill(0, count($types), '?'));
            $stm = $this->pdo->prepare("SELECT * FROM items WHERE typeItem IN ($typesToGet) AND nomItem like ?");
            $params = array_merge($types, ['%' . $nomItem . '%']);
            $stm->execute($params);

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($data)) {

                foreach ($data as $row) {

                    $items[] = new Items(
                        $row['idItem'], 
                        $row['nomItem'], 
                        $row['qteStock'], 
                        $row['typeItem'], 
                        $row['prixItem'],
                        $row['poidsItem'],
                        $row['utilité'],
                        $row['photo'],
                        $row['flagDispo']
                        );
                }        
                return $items;
            }
            return null;

        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    public function updateItemStock($itemId, $quantityPurchased) {
        $sql = "UPDATE items SET qteStock = qteStock - :quantityPurchased WHERE idItem = :itemId AND qteStock >= :quantityPurchased";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'quantityPurchased' => $quantityPurchased,
            'itemId' => $itemId
        ]);
        return $stmt->rowCount() > 0;
    }

    public function deleteItem(int $idItem, string $typeItem): bool
    {
    try {
        $this->pdo->beginTransaction();

        switch ($typeItem) {
                case 'm':
                    $stmt = $this->pdo->prepare('DELETE FROM medicaments WHERE idItem = :idItem');
                    break;
                case 'n':
                    $stmt = $this->pdo->prepare('DELETE FROM nourritures WHERE idItem = :idItem');
                    break;
                case 'a': 
                    $stmt = $this->pdo->prepare('DELETE FROM armes WHERE idItem = :idItem');
                break;
                case 'r':
                    $stmt = $this->pdo->prepare('DELETE FROM armures WHERE idItem = :idItem');
                    break;
                case 'u':
                    $stmt = $this->pdo->prepare('DELETE FROM munitions WHERE idItem = :idItem');
                    break;
                case ' ': //Pour ressource on fait rien parce que pas de table ressource
                    break;
                default:
                    throw new Exception('Type d\'item inconnu.');
            }

            $stmt->execute(['idItem' => $idItem]);


            $stmt = $this->pdo->prepare('DELETE FROM items WHERE idItem = :idItem');
            $stmt->execute(['idItem' => $idItem]);

            $this->pdo->commit();
            return true;
        } 
        
        catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
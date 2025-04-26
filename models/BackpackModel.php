<?php
require_once 'src/class/Backpack.php';
class BackpackModel
{
    public function __construct(private PDO $pdo) {}

    public function selectBackpackById($playerId) {
        $query = "SELECT SUM(i.poidsItem * b.qteItems) AS poidsTotal
                  FROM sacàdos b
                  JOIN items i ON b.idItem = i.idItem
                  WHERE b.idJoueurs = :playerId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['poidsTotal'] ?? 0;
    }
    public function getItemFromBackpack($playerId, $itemId) {
        $query = "SELECT i.idItem, i.nomItem, i.prixItem, i.poidsItem, b.qteItems
                FROM sacàdos b
                JOIN items i ON b.idItem = i.idItem
                WHERE b.idJoueurs = :playerId AND b.idItem = :itemId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
        $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function addItemToBackpack($playerId, $itemId, $quantity) {
        $query = "INSERT INTO sacàdos (idJoueurs, idItem, qteItems, poidsTotal) 
                  VALUES (:playerId, :itemId, :quantity, (Select poidsItem from items where idItem = :itemId) * :quantity)
                  ON DUPLICATE KEY UPDATE qteItems = qteItems + :quantity";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'playerId' => $playerId,
            'itemId' => $itemId,
            'quantity' => $quantity
        ]);
    }
    public function getItemsInBackpack($playerId) {
        $query = "SELECT sacàdos.idItem, sacàdos.qteItems, items.nomItem, items.poidsItem, 
                         items.prixItem, items.utilité, items.typeItem, items.photo
                  FROM sacàdos
                  JOIN items ON sacàdos.idItem = items.idItem
                  WHERE sacàdos.idJoueurs = :playerId";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['playerId' => $playerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sellItemFromBackpack($playerId, $itemId, $itemPrice, $quantity) {
    try {
        $this->pdo->beginTransaction();

        $query = "UPDATE sacàdos 
                  SET qteItems = qteItems - :quantity 
                  WHERE idJoueurs = :playerId AND sacàdos.idItem = :itemId";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'quantity' => $quantity,
            'playerId' => $playerId,
            'itemId' => $itemId
        ]);

        $query = "DELETE FROM sacàdos 
                  WHERE sacàdos.idJoueurs = :playerId AND sacàdos.idItem = :itemId AND qteItems <= 0";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'playerId' => $playerId,
            'itemId' => $itemId
        ]);

        $capsEarned = $itemPrice * 0.6 * $quantity;
        $query = "UPDATE joueurs 
                  SET montantCaps = montantCaps + :capsEarned 
                  WHERE idJoueurs = :playerId";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'capsEarned' => $capsEarned,
            'playerId' => $playerId
        ]);

        $query = "UPDATE items 
                  SET qteStock = qteStock + :quantity 
                  WHERE items.idItem = :itemId";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'quantity' => $quantity,
            'itemId' => $itemId
        ]);

        $this->pdo->commit();
        return true;
    } catch (Exception $e) {
        $this->pdo->rollBack();
        throw $e;
    }
}

    public function mangerNourriture($playerId, $itemId, $pointDeVie) {
        try {
            $this->pdo->beginTransaction();
    
            $query = "UPDATE sacàdos 
                      SET qteItems = qteItems - 1 
                      WHERE idJoueurs = :playerId AND idItem = :itemId AND qteItems > 0";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'playerId' => $playerId,
                'itemId' => $itemId
            ]);
    
            $query = "DELETE FROM sacàdos 
                      WHERE idJoueurs = :playerId AND idItem = :itemId AND qteItems = 0";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'playerId' => $playerId,
                'itemId' => $itemId
            ]);
    
            $query = "UPDATE joueurs 
                      SET pointDeVie = pointDeVie + :pointDeVie 
                      WHERE idJoueurs = :playerId";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'pointDeVie' => $pointDeVie,
                'playerId' => $playerId
            ]);
    
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    public function jeterItem($playerId, $itemId, $quantity) {
        try {
            $this->pdo->beginTransaction();
    
            $query = "UPDATE sacàdos 
                      SET qteItems = qteItems - :quantity 
                      WHERE idJoueurs = :playerId AND idItem = :itemId";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'quantity' => $quantity,
                'playerId' => $playerId,
                'itemId' => $itemId
            ]);
    
            $query = "DELETE FROM sacàdos 
                      WHERE idJoueurs = :playerId AND idItem = :itemId AND qteItems <= 0";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'playerId' => $playerId,
                'itemId' => $itemId
            ]);
            
            $query = "UPDATE joueurs 
            SET dextérité = dextérité + $quantity 
            WHERE idJoueurs = :playerId";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
            'playerId' => $playerId
            ]);

            $this->pdo->commit();
            return true;
        } 
        
        catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
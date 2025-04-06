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
    public function addItemToBackpack($playerId, $itemId, $quantity) {
        $query = "INSERT INTO sacàdos (idJoueurs, idItem, qteItems) 
                  VALUES (:playerId, :itemId, :quantity)
                  ON DUPLICATE KEY UPDATE qteItems = qteItems + :quantity";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'playerId' => $playerId,
            'itemId' => $itemId,
            'quantity' => $quantity
        ]);
    }
    public function getItemsInBackpack($playerId) {
        $query = "SELECT i.idItem, i.nomItem, i.prixItem, i.poidsItem, i.photo, b.qteItems
                  FROM sacàdos b
                  JOIN items i ON b.idItem = i.idItem
                  WHERE b.idJoueurs = :playerId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sellItemFromBackpack($playerId, $itemId, $itemPrice) {
        try {
            $this->pdo->beginTransaction();
    
            // 1. Réduire la quantité de l'item dans le sac à dos
            $query = "UPDATE sacàdos 
                      SET qteItems = qteItems - 1 
                      WHERE idJoueurs = :playerId AND idItem = :itemId";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'playerId' => $playerId,
                'itemId' => $itemId
            ]);
    
            // Supprimer la ligne si la quantité atteint 0
            $query = "DELETE FROM sacàdos 
                      WHERE idJoueurs = :playerId AND idItem = :itemId AND qteItems = 0";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'playerId' => $playerId,
                'itemId' => $itemId
            ]);
    
            // 2. Augmenter le nombre de caps du joueur
            $capsEarned = $itemPrice * 0.6;
            $query = "UPDATE joueurs 
                      SET montantCaps = montantCaps + :capsEarned 
                      WHERE idJoueurs = :playerId";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'capsEarned' => $capsEarned,
                'playerId' => $playerId
            ]);
    
            // 3. Augmenter la quantité de l'item dans la table items
            $query = "UPDATE items 
                      SET qteStock = qteStock + 1 
                      WHERE idItem = :itemId";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'itemId' => $itemId
            ]);
    
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
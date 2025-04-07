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
        $query = "SELECT i.idItem, i.nomItem, i.prixItem, i.poidsItem, i.photo, b.qteItems
                  FROM sacàdos b
                  JOIN items i ON b.idItem = i.idItem
                  WHERE b.idJoueurs = :playerId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
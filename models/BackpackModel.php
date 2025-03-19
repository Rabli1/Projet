<?php
require_once 'src/class/Backpack.php';
class BackpackModel
{
    public function __construct(private PDO $pdo) {}

    public function selectBackpackById($playerId) {
        $query = "SELECT i.idItem, i.nomItem, i.poidsItem, b.qteItems 
                  FROM sacàdos b
                  JOIN items i ON b.idItem = i.idItem
                  WHERE b.idJoueurs = :playerId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
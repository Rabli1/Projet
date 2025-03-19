<?php

class PanierModel
{
    public function __construct(private PDO $pdo) {}

    public function addItemToCart($playerId, $itemId, $quantity)
    {
        $query = "INSERT INTO panier (idJoueur, idItem, quantite)
                  VALUES (:playerId, :itemId, :quantity)
                  ON DUPLICATE KEY UPDATE quantite = quantite + :quantity";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
        $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getCartItems($playerId)
    {
        $query = "SELECT i.idItem, i.nomItem, i.prixItem, i.poidsItem, p.quantite, i.photo
                  FROM panier p
                  JOIN items i ON p.idItem = i.idItem
                  WHERE p.idJoueur = :playerId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateItemQuantity($playerId, $itemId, $quantity)
    {
        $query = "UPDATE panier SET quantite = :quantity
                  WHERE idJoueur = :playerId AND idItem = :itemId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
        $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function removeItemFromCart($playerId, $itemId)
    {
        $query = "DELETE FROM panier WHERE idJoueur = :playerId AND idItem = :itemId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
        $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function clearCart($playerId)
    {
        $query = "DELETE FROM panier WHERE idJoueur = :playerId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
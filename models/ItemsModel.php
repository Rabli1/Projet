<?php

require_once 'src/class/Items.php';

class ItemsModel
{

    // La propriété pourrait être déclarée hors constructeur
    // private PDO $pdo

    // Ici la propriété $pdo est déclarée dans le constructeur directement
    public function __construct(private PDO $pdo) {}
    
    public function selectAll() : null|array {

        try{

            // $this->pdo-> car $pdo est une propriété de l'objet
            $stm = $this->pdo->prepare('SELECT * FROM items');

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
                        $row['utilite'] ?? 0,
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
                $row['utilite'] ?? 0,
                $row['photo'],
                $row['flagDispo']
            );
        }

        return null;
    }
}
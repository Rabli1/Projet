<?php

require_once 'src/class/Nourritures.php';

class NourrituresModel
{

    // La propriété pourrait être déclarée hors constructeur
    // private PDO $pdo

    // Ici la propriété $pdo est déclarée dans le constructeur directement
    public function __construct(private PDO $pdo) {}
    
    public function selectAllNourritures() : null|array {

        try{

            // $this->pdo-> car $pdo est une propriété de l'objet
            $stm = $this->pdo->prepare('SELECT * FROM nourritures');

            $stm->execute();

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($data)) {

                foreach ($data as $row) {

                    $items[] = new Nourritures(
                        $row['idItem'],
                        $row['apportCalorique'],
                        $row['composantNutritif'],
                        $row['mineralPrincipal'],
                        $row['ptsVie']
                        );
                }
                
                return $items;

            }
            
            return null;
            
        } catch (PDOException $e) {
    
            throw new PDOException($e->getMessage(), $e->getCode());
            
        }

    }

    public function selectById(int $id): ?Nourritures {
        $stmt = $this->pdo->prepare('SELECT * FROM nourritures WHERE idItem = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Nourritures(
                $row['idItem'],
                $row['apportCalorique'],
                $row['composantNutritif'],
                $row['mineralPrincipal'],
                $row['ptsVie']
            );
        }
        return null;
    }
}
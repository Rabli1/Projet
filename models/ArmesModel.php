<?php

require_once 'src/class/Armes.php';

class ArmesModel
{

    // La propriété pourrait être déclarée hors constructeur
    // private PDO $pdo

    // Ici la propriété $pdo est déclarée dans le constructeur directement
    public function __construct(private PDO $pdo) {}
    
    public function selectAllArmes() : null|array {

        try{

            // $this->pdo-> car $pdo est une propriété de l'objet
            $stm = $this->pdo->prepare('SELECT * FROM armes');

            $stm->execute();

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($data)) {

                foreach ($data as $row) {

                    $items[] = new Armes(
                        $row['idItem'],
                        $row['efficacité'],
                        $row['typeArmes'],
                        $row['description'],
                        $row['calibre']
                        );
                }
                
                return $items;

            }
            
            return null;
            
        } catch (PDOException $e) {
    
            throw new PDOException($e->getMessage(), $e->getCode());
            
        }

    }

    public function selectById(int $id): ?Armes {
        $stmt = $this->pdo->prepare('SELECT * FROM armes WHERE idItem = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Armes(
                $row['idItem'],
                $row['efficacité'],
                $row['typeArmes'],
                $row['description'],
                $row['calibre']
            );
        }
        return null;
    }
}
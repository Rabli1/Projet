<?php

require_once 'src/class/Médicaments.php';

class MédicamentsModel
{

    // La propriété pourrait être déclarée hors constructeur
    // private PDO $pdo

    // Ici la propriété $pdo est déclarée dans le constructeur directement
    public function __construct(private PDO $pdo) {}
    
    public function selectAllMed() : null|array {

        try{

            // $this->pdo-> car $pdo est une propriété de l'objet
            $stm = $this->pdo->prepare('SELECT * FROM médicaments');

            $stm->execute();

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($data)) {

                foreach ($data as $row) {

                    $items[] = new Médicaments(
                        $row['idItem'],
                        $row['duréeEffet'],
                        $row['effetIndésirable'],
                        $row['ptsVie'],
                        $row['effet']
                        );
                }
                
                return $items;

            }
            
            return null;
            
        } catch (PDOException $e) {
    
            throw new PDOException($e->getMessage(), $e->getCode());
            
        }

    }
}
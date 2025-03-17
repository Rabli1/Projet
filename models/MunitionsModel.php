<?php

require_once 'src/class/Munitions.php';

class MunitionsModels
{

    // La propriété pourrait être déclarée hors constructeur
    // private PDO $pdo

    // Ici la propriété $pdo est déclarée dans le constructeur directement
    public function __construct(private PDO $pdo) {}
    
    public function selectAllMunitions() : null|array {

        try{

            // $this->pdo-> car $pdo est une propriété de l'objet
            $stm = $this->pdo->prepare('SELECT * FROM munitions');

            $stm->execute();

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($data)) {

                foreach ($data as $row) {

                    $items[] = new Munitions(
                        $row['idItem'],
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
}
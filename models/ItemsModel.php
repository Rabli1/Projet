<?php

require_once 'src/class/Items.php';

class ItemsModel
{

    // La propriété pourrait être déclarée hors constructeur
    // private PDO $pdo

    // Ici la propriété $pdo est déclarée dans le constructeur directement
    public function __construct(private PDO $pdo) {}
    
    public function selectAllItems() : null|array {

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
                        $row['utilité'],
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

    public function selectAllArmes() : null|array {

        try{

            // $this->pdo-> car $pdo est une propriété de l'objet
            $stm = $this->pdo->prepare("SELECT * FROM items where typeItem = 'a'");

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
                        $row['utilité'],
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

    public function selectAllMunitions() : null|array {

        try{

            // $this->pdo-> car $pdo est une propriété de l'objet
            $stm = $this->pdo->prepare("SELECT * FROM items where typeItem = 'u'");

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
                        $row['utilité'],
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

    public function selectAllArmures() : null|array {

        try{

            // $this->pdo-> car $pdo est une propriété de l'objet
            $stm = $this->pdo->prepare("SELECT * FROM items where typeItem = 'r'");

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
                        $row['utilité'],
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

    public function selectAllMédicaments() : null|array {

        try{

            // $this->pdo-> car $pdo est une propriété de l'objet
            $stm = $this->pdo->prepare("SELECT * FROM items where typeItem = 'm'");

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
                        $row['utilité'],
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

    public function selectAllNourritures() : null|array {

        try{

            // $this->pdo-> car $pdo est une propriété de l'objet
            $stm = $this->pdo->prepare("SELECT * FROM items where typeItem = 'n'");

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
                        $row['utilité'],
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

    public function selectByTypes($types) {
        try{
            $typesToGet = implode(',', array_fill(0, count($types), '?'));
            $stm = $this->pdo->prepare("SELECT * FROM items WHERE typeItem IN ($typesToGet)");
            $stm->execute($types);

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
                        $row['utilité'],
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
}
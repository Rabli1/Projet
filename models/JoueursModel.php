<?php
require_once 'src/class/Joueurs.php';

class JoueursModel
{
    public function __construct(private PDO $pdo) {}

    public function getAllJoueurs()
    {
        try{
            $stm = $this->pdo->prepare('SELECT * FROM joueurs');
            $stm->execute();
            $data = $stm->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($data)) {
                foreach ($data as $row) {
                    $joueurs[] = new Joueurs(
                        $row['id'], 
                        $row['alias'], 
                        $row['nom'], 
                        $row['prenom'], 
                        $row['montantCaps'], 
                        $row['dexterite'], 
                        $row['pointDeVie'], 
                        $row['poidsMaxTransport'], 
                        $row['motDePasse'], 
                        $row['estAdmin']
                    );
                }
                return $joueurs;
            }
            return null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function getJoueurById($id)
    {
        try {
            // Update the query to use the correct column name
            $stm = $this->pdo->prepare('SELECT * FROM joueurs WHERE idJoueurs = :id');
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->execute();
            $data = $stm->fetch(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                return new Joueurs(
                    $data['idJoueurs'],
                    $data['alias'],
                    $data['nom'],
                    $data['prenom'],
                    $data['montantCaps'],
                    $data['dextérité'],
                    $data['pointDeVie'],
                    $data['poidsMaxTransport'],
                    $data['motDePasse'],
                    $data['estAdmin']
                );
            }
            return null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        }
        public function updateCaps($joueurId, $newCaps) {
            $sql = "UPDATE joueurs SET montantCaps = :newCaps WHERE idJoueur = :joueurId";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['newCaps' => $newCaps, 'joueurId' => $joueurId]);
        }
}
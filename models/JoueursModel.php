<?php
require_once 'src/class/Joueurs.php';

class JoueursModel
{
    public function __construct(private PDO $pdo) {}

    public function getAllJoueurs() {
        try {
            $stm = $this->pdo->prepare('SELECT * FROM joueurs');
            $stm->execute();
            $data = $stm->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($data)) {
                foreach ($data as $row) {
                    $joueurs[] = new Joueurs(
                        $row['idJoueurs'], 
                        $row['alias'], 
                        $row['nom'], 
                        $row['prenom'], 
                        $row['montantCaps'], 
                        $row['dextérité'], 
                        $row['pointDeVie'], 
                        $row['poidsMaxTransport'], 
                        $row['motDePasse'], 
                        $row['estAdmin'],
                        $row['ajoutCapsCount']
                    );
                }
                return $joueurs;
            }
            return [];
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function getJoueurById($id) {
        try {
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
                    $data['estAdmin'],
                    $data['ajoutCapsCount']
                );
            }
            return null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getJoueurByAlias($alias) {
        $stmt = $this->pdo->prepare('SELECT * FROM joueurs WHERE alias = :alias');
        $stmt->execute(['alias' => $alias]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($data) {
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
                $data['estAdmin'],
                $data['ajoutCapsCount']
            );
        }
    
        return null;
    }

    public function updateCaps($joueurId, $newCaps) {
        $sql = "UPDATE joueurs SET montantCaps = :newCaps WHERE idJoueurs = :joueurId";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['newCaps' => $newCaps, 'joueurId' => $joueurId]);
    }

    public function updateDexterity($playerId, $newDexterity) {
        $query = "UPDATE joueurs SET dextérité = :newDexterity WHERE idJoueurs = :playerId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':newDexterity', $newDexterity, PDO::PARAM_INT);
        $stmt->bindParam(':playerId', $playerId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updatePdv($joueurId, $newHp) {
        $sql = "UPDATE joueurs SET pointDeVie = :newHp WHERE idJoueurs = :joueurId";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['newHp' => $newHp, 'joueurId' => $joueurId]);
    }

    public function addNewJoueur($prenom, $nom, $alias, $motDePasse) {
        $sql = "INSERT INTO joueurs (prenom, nom, alias, motDePasse, ajoutCapsCount) VALUES (:prenom, :nom, :alias, :motDePasse, 0)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['prenom' => $prenom, 'nom' => $nom, 'alias' => $alias, 'motDePasse' => $motDePasse]);
    }

    public function userExist($identifier) {
        try {
            $sql = "SELECT COUNT(*) FROM joueurs WHERE alias = :identifier";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':identifier', $identifier, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function increaseCaps($joueurId) {
        $query = "SELECT montantCaps, ajoutCapsCount FROM joueurs WHERE idJoueurs = :joueurId";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['joueurId' => $joueurId]);
        $joueur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($joueur && $joueur['ajoutCapsCount'] < 3) {
            $capsAjoute = match ($joueur['ajoutCapsCount']) {
                0 => 300,
                1 => 200,
                2 => 100,
                default => 0,
            };

            $caps = $joueur['montantCaps'] + $capsAjoute;
            $count = $joueur['ajoutCapsCount'] + 1;

            $updateQuery = "UPDATE joueurs SET montantCaps = :caps, ajoutCapsCount = :count WHERE idJoueurs = :joueurId";
            $updateStmt = $this->pdo->prepare($updateQuery);
            $updateStmt->execute([
                'caps' => $caps,
                'count' => $count,
                'joueurId' => $joueurId,
            ]);

            return $capsAjoute;
        }

        return 0;
    }
}
<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/Societe.php';

class repository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnexion();
    }

    // CREATE : ajouter une société
    public function ajouter(Societe $societe): bool {
        $sql = "INSERT INTO societe (code_societe,nom, secteur, region, audit, adresse, email, statut, note)
                VALUES (:code_societe,:nom, :secteur, :region, :audit, :adresse, :email, :statut, :note)";

        

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'code_societe' => $societe->code_societe,
            'nom' => $societe->nom_societe,
            'secteur'      => $societe->secteur,
            'region'       => $societe->region,
            'audit'        => $societe->audit,
            'adresse'      => $societe->adresse,
            'email'        => $societe->email,
            'statut'       => $societe->statut,
            'note'         => $societe->note,
        ]);
    }

    // READ : récupérer toutes les sociétés
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM societe");
        $resultats = $stmt->fetchAll();

        // Transformer chaque ligne en objet Societe
        $societes = [];
        foreach ($resultats as $ligne) {
            $societes[] = new Societe(
                $ligne['code_societe'],
                $ligne['nom'],
                $ligne['secteur'],
                $ligne['region'],
                $ligne['audit'],
                $ligne['adresse'],
                $ligne['email'],
                $ligne['statut'],
                $ligne['note']
            );
        }
        return $societes;
    }

    // READ : récupérer une société par son code
    public function getByCode(string $code_societe): ?Societe {
        $sql = "SELECT * FROM societe WHERE code_societe = :code_societe";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['code_societe' => $code_societe]);
        $ligne = $stmt->fetch();

        if (!$ligne) {
            return null;
        }

        return new Societe(
            $ligne['nom'],
            $ligne['code'],
            $ligne['secteur'],
            $ligne['region'],
            $ligne['audit'],
            $ligne['adresse'],
            $ligne['email'],
            $ligne['statut'],
            $ligne['note']
        );
    }

    // UPDATE : mettre à jour une société
    public function modifier(Societe $societe): bool {
        $sql = "UPDATE societe SET
                    nom = :nom,
                    secteur = :secteur,
                    region = :region,
                    audit = :audit,
                    adresse = :adresse,
                    email = :email,
                    statut = :statut,
                    note = :note
                WHERE code_societe = :code_societe";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'code_societe' => $societe->code_societe,
            'nom' => $societe->nom_societe,
            'secteur'      => $societe->secteur,
            'region'       => $societe->region,
            'audit'        => $societe->audit,
            'adresse'      => $societe->adresse,
            'email'        => $societe->email,
            'statut'       => $societe->statut,
            'note'         => $societe->note,
        ]);
    }

    // DELETE : supprimer une société
    public function supprimer(string $code_societe): bool {
        $sql = "DELETE FROM societe WHERE code_societe = :code_societe";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['code_societe' => $code_societe]);
    }
}
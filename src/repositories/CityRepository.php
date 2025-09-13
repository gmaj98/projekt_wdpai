<?php

require_once 'Repository.php';

class CityRepository extends Repository {
   

    public function getCities(): array 
    {
        $stmt = $this->database->connect()->prepare(
            'SELECT * FROM public.cards ORDER BY id ASC'
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
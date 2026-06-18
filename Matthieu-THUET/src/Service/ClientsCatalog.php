<?php

namespace App\Service;

final class ClientsCatalog
{
    /**
     * @return list<array{
     *   slug: string,
     *   name: string,
     *   image: string|null,
     *   recommendation: string|null,
     *   category: string,
     *   description: string|null
     * }>
     */
    public function all(): array
    {
        return [
            [
                'slug' => 'ids-le-phare',
                'name' => 'IDS le Phare',
                'image' => 'images/clients/le-phare.png',
                'recommendation' => "phrase de recomandation",
                'category' => "Consulting en accessibilité web",
                'description' => "Ils m'ont demandé de consulter l'accessibilité de leur nouveau site pour une ludothèque, avec des fonctionnalités d'emprunt de jeux de société et de livres en ligne.",
            ],
            [
                'slug' => 'christophe-kippelen',
                'name' => 'Christophe Kippelen',
                'image' => 'images/clients/christophe-kippelen.png',
                'recommendation' => "phrase de recomandation",
                'category' => 'Site WordPress',
                'description' => "Création d’un site WordPress avec une page d’accueil et une page de contact.",
            ],
        ];
    }
}

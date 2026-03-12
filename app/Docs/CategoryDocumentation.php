<?php

namespace App\Docs;

use Illuminate\Http\Request;
use App\Models\Category;
use OpenApi\Attributes as OA;

interface CategoryDocumentation
{
    #[OA\Get(
        path: "/api/categories",
        summary: "Afficher la liste des catégories de l'utilisateur",
        tags: ["Catégories"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Response(response: 200, description: "Liste des catégories récupérée")]
    public function index(Request $request);




    #[OA\Post(
        path: "/api/categories",
        summary: "Ajouter une nouvelle catégorie",
        tags: ["Catégories"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Pizzas", description: "min:3 | max:64")
            ]
        )
    )]
    #[OA\Response(response: 201, description: "Catégorie créée avec succès")]
    public function store(Request $request);



    #[OA\Get(
        path: "/api/categories/{id}",
        summary: "Afficher les détails d'une catégorie spécifique",
        tags: ["Catégories"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Parameter(
        name: "id",
        description: "ID de la catégorie",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(response: 200, description: "Détails de la catégorie récupérés")]
    public function show(Category $id);



    #[OA\Put(
        path: "/api/categories/{id}",
        summary: "Modifier une catégorie existante",
        tags: ["Catégories"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Parameter(
        name: "id",
        description: "ID de la catégorie à modifier",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Burgers M")
            ]
        )
    )]
    #[OA\Response(response: 200, description: "Catégorie mise à jour avec succès")]
    public function update(Request $request, Category $id);



    #[OA\Delete(
        path: "/api/categories/{id}",
        summary: "Supprimer une catégorie",
        tags: ["Catégories"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Parameter(
        name: "id",
        description: "ID de la catégorie à supprimer",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(response: 200, description: "Catégorie supprimée avec succès")]
    public function destroy(Category $id);



    #[OA\Post(
        path: "/api/categories/{id}/plats",
        summary: "Affecter un plat à une catégorie",
        tags: ["Catégories"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Parameter(
        name: "id",
        description: "ID de la catégorie",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["plat_id"],
            properties: [
                new OA\Property(property: "plat_id", type: "integer", example: 1, description: "L'ID du plat existant")
            ]
        )
    )]
    #[OA\Response(response: 200, description: "Le plat a été ajouté à la catégorie avec succès")]
    public function add(Request $request, $id);
}
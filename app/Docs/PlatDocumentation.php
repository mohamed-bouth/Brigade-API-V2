<?php

namespace App\Docs;

use Illuminate\Http\Request;
use App\Models\Plat;
use OpenApi\Attributes as OA;

interface PlatDocumentation
{

    #[OA\Get(
        path: "/api/plats",
        summary: "Afficher la liste des plats de l'utilisateur",
        tags: ["Plats"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Response(response: 200, description: "Liste des plats récupérée avec succès")]
    public function index(Request $request);



    #[OA\Post(
        path: "/api/plats",
        summary: "Ajouter un nouveau plat",
        tags: ["Plats"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name", "description", "price"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Tacos Poulet", description: "min:3 | max:64"),
                new OA\Property(property: "description", type: "string", example: "Délicieux tacos avec frites et sauce algérienne"),
                new OA\Property(property: "price", type: "number", format: "float", example: 45.50)
            ]
        )
    )]
    #[OA\Response(response: 201, description: "Plat créé avec succès")]
    public function store(Request $request);



    #[OA\Get(
        path: "/api/plats/{id}",
        summary: "Afficher les détails d'un plat spécifique",
        tags: ["Plats"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Parameter(
        name: "id",
        description: "ID du plat",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(response: 200, description: "Détails du plat récupérés")]
    public function show(Plat $id);



    #[OA\Put(
        path: "/api/plats/{id}",
        summary: "Modifier un plat existant",
        tags: ["Plats"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Parameter(
        name: "id",
        description: "ID du plat à modifier",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name", "description", "price"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Tacos Viande Hachée"),
                new OA\Property(property: "description", type: "string", example: "Modification de la description"),
                new OA\Property(property: "price", type: "number", format: "float", example: 50.00)
            ]
        )
    )]
    #[OA\Response(response: 200, description: "Plat mis à jour avec succès")]
    public function update(Request $request, Plat $id);



    #[OA\Delete(
        path: "/api/plats/{id}",
        summary: "Supprimer un plat",
        tags: ["Plats"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Parameter(
        name: "id",
        description: "ID du plat à supprimer",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(response: 200, description: "Plat supprimé avec succès")]
    public function destroy(Plat $id);
}
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
        content: new OA\MediaType(
            mediaType: "multipart/form-data",
            schema: new OA\Schema(
                required: ["name", "description", "price", "image"], 
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Tacos Poulet", description: "min:3 | max:64"),
                    new OA\Property(property: "description", type: "string", example: "Délicieux tacos avec frites et sauce algérienne"),
                    new OA\Property(property: "price", type: "number", format: "float", example: 45.50),
                    new OA\Property(property: "image", type: "string", format: "binary", description: "Image du plat (jpeg, png, jpg, webp)")
                ]
            )
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



    #[OA\Post( // غيرنا هذا إلى Post لكي تعمل واجهة رفع الملفات
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
        content: new OA\MediaType(
            mediaType: "multipart/form-data",
            schema: new OA\Schema(
                required: ["_method", "name", "description", "price"], 
                properties: [
                    new OA\Property(property: "_method", type: "string", example: "PUT", description: "Astuce Laravel pour forcer la méthode PUT"),
                    new OA\Property(property: "name", type: "string", example: "Tacos Viande Hachée"),
                    new OA\Property(property: "description", type: "string", example: "Modification de la description"),
                    new OA\Property(property: "price", type: "number", format: "float", example: 50.00),
                    new OA\Property(property: "image", type: "string", format: "binary", description: "Nouvelle image (Optionnelle)")
                ]
            )
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
<?php

namespace App\Docs;

use Illuminate\Http\Request;
use App\Models\Plat;
use OpenApi\Attributes as OA;

interface PlatDocumentation
{
    #[OA\Get(
        path: "/api/plats",
        summary: "Afficher la liste des plats de l'utilisateur authentifié",
        tags: ["Plats"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Response(
        response: 200,
        description: "Liste des plats récupérée avec succès"
    )]
    #[OA\Response(
        response: 401,
        description: "Utilisateur non authentifié"
    )]
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
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "Tacos Poulet",
                        description: "min:3 | max:64"
                    ),
                    new OA\Property(
                        property: "description",
                        type: "string",
                        example: "Délicieux tacos avec frites et sauce algérienne"
                    ),
                    new OA\Property(
                        property: "price",
                        type: "number",
                        format: "float",
                        example: 45.50
                    ),
                    new OA\Property(
                        property: "image",
                        type: "string",
                        format: "binary",
                        description: "Image du plat (jpeg, png, jpg, webp)"
                    ),
                    new OA\Property(
                        property: "ingredient_ids",
                        type: "array",
                        description: "Liste optionnelle des IDs des ingrédients",
                        items: new OA\Items(type: "integer", example: 1)
                    )
                ]
            )
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Plat créé avec succès"
    )]
    #[OA\Response(
        response: 401,
        description: "Utilisateur non authentifié"
    )]
    #[OA\Response(
        response: 403,
        description: "Accès refusé, réservé aux administrateurs"
    )]
    #[OA\Response(
        response: 422,
        description: "Erreur de validation"
    )]
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
    #[OA\Response(
        response: 200,
        description: "Détails du plat récupérés"
    )]
    #[OA\Response(
        response: 401,
        description: "Utilisateur non authentifié"
    )]
    #[OA\Response(
        response: 404,
        description: "Plat introuvable"
    )]
    public function show(Plat $id);



        #[OA\Post(
        path: "/api/plats/{id}",
        summary: "Modifier un plat existant",
        description: "Requête envoyée en POST avec _method=PUT pour permettre l'envoi de fichiers via multipart/form-data dans Swagger/Laravel.",
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
                    new OA\Property(
                        property: "_method",
                        type: "string",
                        example: "PUT",
                        description: "Méthode simulée pour Laravel"
                    ),
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "Tacos Viande Hachée",
                        description: "min:3 | max:64"
                    ),
                    new OA\Property(
                        property: "description",
                        type: "string",
                        example: "Modification de la description"
                    ),
                    new OA\Property(
                        property: "price",
                        type: "number",
                        format: "float",
                        example: 50.00
                    ),
                    new OA\Property(
                        property: "image",
                        type: "string",
                        format: "binary",
                        description: "Nouvelle image optionnelle"
                    ),
                    new OA\Property(
                        property: "ingredient_ids",
                        type: "array",
                        description: "Liste optionnelle des IDs des ingrédients",
                        items: new OA\Items(type: "integer", example: 1)
                    ),
                    new OA\Property(
                        property: "is_available",
                        type: "integer",
                        example: 1,
                        description: "Disponible ou non"
                    )
                ]
            )
        )
    )]
    #[OA\Response(response: 200, description: "Plat mis à jour avec succès")]
    #[OA\Response(response: 401, description: "Utilisateur non authentifié")]
    #[OA\Response(response: 403, description: "Accès refusé ou action non autorisée")]
    #[OA\Response(response: 404, description: "Plat introuvable")]
    #[OA\Response(response: 422, description: "Erreur de validation")]
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
    #[OA\Response(
        response: 200,
        description: "Plat supprimé avec succès"
    )]
    #[OA\Response(
        response: 401,
        description: "Utilisateur non authentifié"
    )]
    #[OA\Response(
        response: 403,
        description: "Accès refusé ou action non autorisée"
    )]
    #[OA\Response(
        response: 404,
        description: "Plat introuvable"
    )]
    public function destroy(Plat $id);
}
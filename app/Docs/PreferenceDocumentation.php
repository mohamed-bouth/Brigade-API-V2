<?php

namespace App\Docs;

use Illuminate\Http\Request;
use App\Models\Preference;
use OpenApi\Attributes as OA;

interface PreferenceDocumentation
{
    #[OA\Post(
        path: "/api/profile",
        summary: "Ajouter une nouvelle préférence pour l'utilisateur authentifié",
        tags: ["Preferences"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["ingredient", "type"],
            properties: [
                new OA\Property(
                    property: "ingredient",
                    type: "string",
                    maxLength: 30,
                    example: "tomato",
                    description: "Nom de l'ingrédient"
                ),
                new OA\Property(
                    property: "type",
                    type: "string",
                    enum: ["likes_it", "dislikes_it", "allergic_to_it", "not_preferred", "forbidden"],
                    example: "dislikes_it",
                    description: "Type de préférence"
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Préférence créée avec succès"
    )]
    #[OA\Response(
        response: 401,
        description: "Utilisateur non authentifié"
    )]
    #[OA\Response(
        response: 422,
        description: "Erreur de validation"
    )]
    public function store(Request $request);



    #[OA\Put(
        path: "/api/profile/{id}",
        summary: "Modifier une préférence existante",
        tags: ["Preferences"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Parameter(
        name: "id",
        description: "ID de la préférence",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["ingredient", "type"],
            properties: [
                new OA\Property(
                    property: "ingredient",
                    type: "string",
                    maxLength: 30,
                    example: "onion",
                    description: "Nom de l'ingrédient"
                ),
                new OA\Property(
                    property: "type",
                    type: "string",
                    enum: ["likes_it", "dislikes_it", "allergic_to_it", "not_preferred", "forbidden"],
                    example: "not_preferred",
                    description: "Type de préférence"
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Préférence mise à jour avec succès"
    )]
    #[OA\Response(
        response: 401,
        description: "Utilisateur non authentifié"
    )]
    #[OA\Response(
        response: 404,
        description: "Préférence introuvable"
    )]
    #[OA\Response(
        response: 422,
        description: "Erreur de validation"
    )]
    public function update(Request $request, Preference $id);
}
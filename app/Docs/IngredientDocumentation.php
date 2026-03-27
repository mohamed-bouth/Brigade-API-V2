<?php

namespace App\Docs;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use OpenApi\Attributes as OA;

interface IngredientDocumentation
{
    #[OA\Get(
        path: "/api/ingredients",
        summary: "Afficher la liste de tous les ingrédients",
        tags: ["Ingredients"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Response(
        response: 200,
        description: "Liste des ingrédients récupérée avec succès"
    )]
    #[OA\Response(
        response: 401,
        description: "Utilisateur non authentifié"
    )]
    #[OA\Response(
        response: 403,
        description: "Accès refusé, réservé aux administrateurs"
    )]
    public function index();



    #[OA\Post(
        path: "/api/ingredients",
        summary: "Ajouter un nouvel ingrédient",
        tags: ["Ingredients"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name", "tags"],
            properties: [
                new OA\Property(
                    property: "name",
                    type: "string",
                    example: "Tomato",
                    description: "min:3 | max:30 | unique"
                ),
                new OA\Property(
                    property: "tags",
                    type: "array",
                    description: "Liste de tags liés à l'ingrédient",
                    items: new OA\Items(type: "string", example: "vegetable")
                )
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Ingrédient créé avec succès"
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



    #[OA\Put(
        path: "/api/ingredients/{id}",
        summary: "Modifier un ingrédient existant",
        tags: ["Ingredients"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Parameter(
        name: "id",
        description: "ID de l'ingrédient à modifier",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name", "tags"],
            properties: [
                new OA\Property(
                    property: "name",
                    type: "string",
                    example: "Onion",
                    description: "min:3 | max:30 | unique"
                ),
                new OA\Property(
                    property: "tags",
                    type: "array",
                    description: "Liste de tags liés à l'ingrédient",
                    items: new OA\Items(type: "string", example: "vegetable")
                )
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Ingrédient mis à jour avec succès"
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
        response: 404,
        description: "Ingrédient introuvable"
    )]
    #[OA\Response(
        response: 422,
        description: "Erreur de validation"
    )]
    public function update(Request $request, Ingredient $id);



    #[OA\Delete(
        path: "/api/ingredients/{id}",
        summary: "Supprimer un ingrédient",
        tags: ["Ingredients"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Parameter(
        name: "id",
        description: "ID de l'ingrédient à supprimer",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(
        response: 200,
        description: "Ingrédient supprimé avec succès"
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
        response: 404,
        description: "Ingrédient introuvable"
    )]
    public function destroy(Request $request, Ingredient $id);
}
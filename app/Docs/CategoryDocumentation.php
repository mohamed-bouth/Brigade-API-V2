<?php

namespace App\Docs;

use Illuminate\Http\Request;
use App\Models\Category;
use OpenApi\Attributes as OA;

interface CategoryDocumentation
{
    #[OA\Get(
        path: "/api/categories",
        summary: "Afficher la liste des catégories de l'utilisateur authentifié",
        tags: ["Catégories"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Response(
        response: 200,
        description: "Liste des catégories récupérée"
    )]
    #[OA\Response(
        response: 401,
        description: "Utilisateur non authentifié"
    )]
    public function index(Request $request);



    #[OA\Post(
        path: "/api/categories",
        summary: "Ajouter une nouvelle catégorie",
        tags: ["Catégories"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\MediaType(
            mediaType: "multipart/form-data",
            schema: new OA\Schema(
                required: ["name", "image"],
                properties: [
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "Pizzas",
                        description: "min:3 | max:64"
                    ),
                    new OA\Property(
                        property: "description",
                        type: "string",
                        example: "this pizzas is very good",
                        description: "max:256"
                    ),
                    new OA\Property(
                        property: "image",
                        type: "string",
                        format: "binary",
                        description: "Image de la catégorie (jpeg, png, jpg, webp)"
                    ),
                    new OA\Property(
                        property: "color",
                        type: "string",
                        example: "red",
                        description: "Champ optionnel pour aider le front-end"
                    )
                ]
            )
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Catégorie créée avec succès"
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
    #[OA\Response(
        response: 200,
        description: "Détails de la catégorie récupérés"
    )]
    #[OA\Response(
        response: 401,
        description: "Utilisateur non authentifié"
    )]
    #[OA\Response(
        response: 404,
        description: "Catégorie introuvable"
    )]
    public function show(Category $id);



    #[OA\Post(
        path: "/api/categories/{id}",
        summary: "Modifier une catégorie existante",
        description: "Requête envoyée en POST avec _method=PUT pour permettre l'envoi de fichiers via multipart/form-data dans Swagger/Laravel.",
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
        content: new OA\MediaType(
            mediaType: "multipart/form-data",
            schema: new OA\Schema(
                required: ["_method", "name"],
                properties: [
                    new OA\Property(
                        property: "_method",
                        type: "string",
                        example: "PUT",
                        description: "Astuce Laravel pour simuler la méthode PUT"
                    ),
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "Burgers M",
                        description: "min:3 | max:64"
                    ),
                    new OA\Property(
                        property: "description",
                        type: "string",
                        example: "this pizzas isn't good anymore",
                        description: "max:256"
                    ),
                    new OA\Property(
                        property: "image",
                        type: "string",
                        format: "binary",
                        description: "Nouvelle image optionnelle"
                    ),
                    new OA\Property(
                        property: "color",
                        type: "string",
                        example: "green",
                        description: "Champ optionnel pour aider le front-end"
                    )
                ]
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Catégorie mise à jour avec succès"
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
        description: "Catégorie introuvable"
    )]
    #[OA\Response(
        response: 422,
        description: "Erreur de validation"
    )]
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
    #[OA\Response(
        response: 200,
        description: "Catégorie supprimée avec succès"
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
        description: "Catégorie introuvable"
    )]
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
                new OA\Property(
                    property: "plat_id",
                    type: "integer",
                    example: 1,
                    description: "ID du plat existant"
                )
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Le plat a été ajouté à la catégorie avec succès"
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
        description: "Plat ou catégorie introuvable"
    )]
    #[OA\Response(
        response: 422,
        description: "Erreur de validation"
    )]
    public function add(Request $request, $id);
}
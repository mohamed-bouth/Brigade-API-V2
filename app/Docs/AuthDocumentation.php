<?php

namespace App\Docs;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

interface AuthDocumentation
{

    #[OA\Post(
        path: "/api/register",
        summary: "Créer un nouveau compte utilisateur",
        tags: ["Authentification"]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name", "email", "password"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Ahmed Ali"),
                new OA\Property(property: "email", type: "string", format: "email", example: "ahmed@example.com"),
                new OA\Property(property: "password", type: "string", format: "password", example: "password123")
            ]
        )
    )]
    #[OA\Response(response: 201, description: "Utilisateur créé avec succès et token généré")]
    #[OA\Response(response: 422, description: "Erreur de validation des données")]
    public function register(Request $request);



    #[OA\Post(
        path: "/api/login",
        summary: "Se connecter pour obtenir un token",
        tags: ["Authentification"]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["email", "password"],
            properties: [
                new OA\Property(property: "email", type: "string", format: "email", example: "ahmed@example.com"),
                new OA\Property(property: "password", type: "string", format: "password", example: "password123")
            ]
        )
    )]
    #[OA\Response(response: 200, description: "Connexion réussie et token généré")]
    #[OA\Response(response: 401, description: "Email ou mot de passe incorrect")]
    public function login(Request $request);



    #[OA\Post(
        path: "/api/logout",
        summary: "Se déconnecter et révoquer le token actuel",
        tags: ["Authentification"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Response(response: 200, description: "Déconnexion réussie")]
    #[OA\Response(response: 401, description: "Non autorisé (Token manquant ou invalide)")]
    public function logout(Request $request);
}
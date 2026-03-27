<?php

namespace App\Docs;

use Illuminate\Http\Request;
use App\Models\Plat;
use OpenApi\Attributes as OA;

interface RecommendationDocumentation
{
    #[OA\Post(
        path: "/api/recommendations/analyze/{id}",
        summary: "Lancer une analyse IA pour un plat",
        description: "Crée une recommandation avec le statut processing puis envoie le traitement vers la queue ai.",
        tags: ["Recommendations"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Parameter(
        name: "id",
        description: "ID du plat à analyser",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(
        response: 200,
        description: "Demande d'analyse reçue avec succès"
    )]
    #[OA\Response(
        response: 401,
        description: "Utilisateur non authentifié"
    )]
    #[OA\Response(
        response: 404,
        description: "Plat introuvable"
    )]
    public function analyze(Request $request, Plat $id);



    #[OA\Get(
        path: "/api/recommendations",
        summary: "Afficher l'historique des analyses IA de l'utilisateur",
        description: "Retourne la liste des plats qui possèdent des recommandations liées à l'utilisateur authentifié.",
        tags: ["Recommendations"],
        security: [["bearerAuth" => []]]
    )]
    #[OA\Response(
        response: 200,
        description: "Historique récupéré avec succès"
    )]
    #[OA\Response(
        response: 401,
        description: "Utilisateur non authentifié"
    )]
    public function history(Request $request);



    #[OA\Get(
        path: "/api/recommendations/{id}",
        summary: "Afficher la dernière recommandation IA d'un plat",
        description: "Le paramètre id représente l'ID du plat, pas l'ID de la recommandation.",
        tags: ["Recommendations"],
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
        description: "Dernière recommandation récupérée avec succès"
    )]
    #[OA\Response(
        response: 401,
        description: "Utilisateur non authentifié"
    )]
    #[OA\Response(
        response: 404,
        description: "Plat introuvable"
    )]
    public function show(Request $request, Plat $id);
}
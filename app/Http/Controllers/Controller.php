<?php
namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Tourist Route Management API",
    version: "1.0.0",
    description: "API documentation for the Tourist Route project",
    contact: new OA\Contact(email: "admin@example.com")
)]
#[OA\Server(url: "http://localhost:8000",description: "Local Development Server")]
abstract class Controller
{
    //
}
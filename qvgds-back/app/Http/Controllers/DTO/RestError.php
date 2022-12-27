<?php
declare(strict_types=1);

namespace App\Http\Controllers\DTO;

use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(title: "Error", description: "Error description")]
final readonly class RestError
{
    #[Property]
    public string $error;

}

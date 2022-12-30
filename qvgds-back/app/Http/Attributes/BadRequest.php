<?php
declare(strict_types=1);

namespace App\Http\Attributes;

use App\Http\Controllers\DTO\RestError;
use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class BadRequest extends OA\Response
{
    public function __construct()
    {
        parent::__construct(
            response: 400,
            description: 'Bad request',
            content: new OA\JsonContent(type: RestError::class));
    }
}

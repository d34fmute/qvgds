<?php
declare(strict_types=1);

namespace QVGDS\Exception;

final class QVGDSExceptionBuilder
{
    public int $code;
    public string $message;

    public function withMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function badRequest(): self
    {
        $this->code = 400;

        return $this;
    }

    public function notFound(): self
    {
        $this->code = 404;

        return $this;
    }

}

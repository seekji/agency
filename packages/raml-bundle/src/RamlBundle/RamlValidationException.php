<?php
declare(strict_types = 1);

namespace Raml\RamlBundle;

final class RamlValidationException extends \RuntimeException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}

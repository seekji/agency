<?php
declare(strict_types = 1);

namespace Raml\RamlBundle;

interface VndCustomRamlException
{
    public function getMessage();

    public function getErrorCode() : string;

    public function getHttpStatusCode() : int;
}

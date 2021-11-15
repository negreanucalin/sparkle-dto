<?php

namespace SparkleDTO;

use SparkleDTO\Exceptions\IdGenerationException;

class DataTransferObjectWithId extends DataTransferObject
{
    private int $idLength = 20;

    public function getIdAttribute()
    {
        return bin2hex(random_bytes($this->idLength));
    }
}
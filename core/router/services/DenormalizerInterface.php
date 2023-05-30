<?php

namespace app\core\router\services;

interface DenormalizerInterface
{
    public function mapToDenormalizedData($normalizedData): array;
}

<?php

namespace app\core\router\services;

interface NormalizerInterface
{
    public function mapToNormalizedData($data);
}

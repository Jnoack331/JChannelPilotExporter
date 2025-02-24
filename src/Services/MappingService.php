<?php

namespace Jnoack\JChannelPilotExporter\Services;

class MappingService
{
    private array $mapping = [
        'id',
        'productNumber',
        'name',
        'description',
    ];

    public function getMapping(): array {
        return $this->mapping;
    }
}
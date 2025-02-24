<?php

namespace Jnoack\JChannelPilotExporter\Services;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\PartialEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;

class ExportService implements ExportServiceInterface
{
    public function __construct(
        private readonly EntityRepository $productRepository,
        private readonly Connection $connection,
        private readonly MappingService $mappingService,
    ) {
    }

    public function export(): void
    {
        $sql = <<<SQL
SELECT LOWER(HEX(product.id)) FROM product
 WHERE product.parent_id IS NULL AND product.id NOT IN (
    SELECT subProduct.parent_id From product as subProduct Where subProduct.parent_id IS NOT NULL
)
SQL;
        $result = $this->connection->query($sql);
        $allProductIds = $result->fetchFirstColumn();
        
        $file = fopen('/var/www/html/custom/plugins/JChannelPilotExporter/test.csv', 'w');

        $mapping = $this->mappingService->getMapping();

        $chunkLength = 100;
        foreach(array_chunk($allProductIds, $chunkLength) as $chunk) {
            /** @var EntitySearchResult $products */
            $criteria = new Criteria($chunk);
            $criteria->addFields($mapping);

            $products = $this->productRepository->search($criteria, Context::createCLIContext());
            /** @var PartialEntity $product */
            foreach ($products as $product) {
                $articleData = [];

                foreach ($mapping as $field) {
                    $articleData[$field] = $product->get($field);
                }

                fputcsv($file, $articleData);
            }
        }

        fclose($file);

    }
}
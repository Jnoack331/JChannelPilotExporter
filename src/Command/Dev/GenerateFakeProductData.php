<?php

namespace Jnoack\JChannelPilotExporter\Command\Dev;

use Faker\Factory;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Contracts\Service\Attribute\Required;

#[AsCommand(
    name: 'j:channel_pilot:generate_fake_products',
    description: 'generates fake products for testing purposes.',
)]
class GenerateFakeProductData extends Command
{
    protected EntityRepository $productRepository;

    protected EntityRepository $currencyRepository;

    protected EntityRepository $languageRepository;

    protected EntityRepository $taxRepository;

    #[Required]
    public function setLanguageRepository(
        EntityRepository $languageRepository,
    ) {
        $this->languageRepository = $languageRepository;
    }

    #[Required]
    public function setCurrencyRepository(
        EntityRepository $currencyRepository,
    ) {
        $this->currencyRepository = $currencyRepository;
    }

    #[Required]
    public function setProductRepository(
        EntityRepository $productRepository,
    ) {
        $this->productRepository = $productRepository;
    }

    #[Required]
    public function setTaxRepository(
        EntityRepository $taxRepository,
    ) {
        $this->taxRepository = $taxRepository;
    }

    protected function configure(): void
    {
        $this->setDescription('Does something very special.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $faker = Factory::create();
        $context = Context::createCLIContext();

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', 'English'));
        $languageId = $this->languageRepository->search($criteria, $context)
            ->first()
            ->getId();


        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('isoCode', 'EUR'));
        $currencyId = $this->currencyRepository->search($criteria, $context)
            ->first()
            ->getId();

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('name', 'Standard rate'));
        $taxId = $this->taxRepository->search($criteria, $context)
            ->first()
            ->getId();


        try {
            for ($index = 0; $index < 100; $index++) {
                $chunk = [];
                for ($index2 = 0; $index2 < 100; $index2++) {
                    $chunk[] = [
                        'id' => Uuid::randomHex(),
                        'taxId' => $taxId,
                        'description' => $faker->text(),
                        'price' => [
                            [
                                'currencyId' => $currencyId,
                                'linked' => false,
                                'net' => $faker->randomFloat(2, 1, 1000),
                                'gross' => $faker->randomFloat(2, 1, 1000),
                            ]
                        ],
                        'productNumber' => uniqid('SWFAKE', true),
                        'stock' => $faker->randomNumber(2),
                        'translations' => [
                            $languageId => [
                                'name' => $faker->text(40),
                            ]
                        ]
                    ];
                }

                $this->productRepository->upsert($chunk, $context);
            }
        } catch (\Throwable $throwable) {
            VarDumper::dump($throwable);
        }

        return 0;
    }
}

{

}
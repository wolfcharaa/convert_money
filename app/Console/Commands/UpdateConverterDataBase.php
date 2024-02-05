<?php

namespace App\Console\Commands;

use App\Models\ForexCostActual;
use App\Service\Converter\Converters\ConverterUpdaterFactory;
use App\Service\Converter\ConverterUpdaterInterface;
use Illuminate\Console\Command;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateConverterDataBase extends Command
{
    public function __construct(private readonly ConverterUpdaterFactory $converterUpdaterFactory)
    {
        parent::__construct();
    }

    protected $signature = 'converter:update
     {--type :
        OER = 1,
        LAYER = 2,
        FIXER = 3,
        EXCHANGERATES = 4,
        FREE_CURRENCY = 5
     }';

    protected $description = 'Обновляет базу в соответствиии с выбранным конвертором';

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(): int
    {
        $convertType = $this->option('type');

        if (!array_key_exists($convertType, ConverterUpdaterInterface::CONVERTER_POINTER)) {
            print("Not found {$convertType} from " . ConverterUpdaterInterface::class);
            return CommandAlias::FAILURE;
        }

        /** @var ConverterUpdaterInterface $converter */
        $converter = $this->converterUpdaterFactory
            ->create(ConverterUpdaterInterface::CONVERTER_POINTER[$convertType]);

        $converter->updateConverterInfo();
        $forexCost = new ForexCostActual();
        $forexCost->forex_cost_array = json_encode($converter->getForexCostArray());
        $forexCost->main_forex = $converter->getMainForex();
        $forexCost->save();  //TODO разобраться почему данные не сохраняются в базу данных

        return CommandAlias::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\ForexCostActual;
use App\Service\Converter\Converters\ConverterUpdaterFactory;
use App\Service\Converter\ConverterUpdaterInterface;
use Illuminate\Console\Command;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UpdateConverterDataBase extends Command
{
    public function __construct(private readonly ConverterUpdaterFactory $converterUpdaterFactory)
    {
        parent::__construct();
    }

    protected $signature = 'converter:update';

    protected $description = 'Обновляет базу в соответствиии с выбранным конвертором';

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(): int
    {
        $convertType = $this->choice(
            'Which converter should the data be updated for?',
            []
        );

        if (!array_key_exists($convertType, ConverterUpdaterInterface::CONVERTER_POINTER)) {
            print("Not found {$convertType} from " . ConverterUpdaterInterface::class);
            return Command::FAILURE;
        }

        /** @var ConverterUpdaterInterface $converter */
        $converter = $this->converterUpdaterFactory
            ->create(ConverterUpdaterInterface::CONVERTER_POINTER[$convertType]);


        $converter->updateConverterInfo();
        $forexCost = new ForexCostActual();
        $forexCost->forex_cost_array = json_encode($converter->getForexCostArray());
        $forexCost->main_forex = $converter->getMainForex();
        $forexCost->save();  //TODO разобраться почему данные не сохраняются в базу данных

        return Command::SUCCESS;
    }
}

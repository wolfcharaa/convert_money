<?php

namespace App\Console\Commands;

use App\Models\ForexCost;
use App\Service\Converter\Converters\ConverterUpdaterFactory;
use App\Service\Converter\ConverterUpdaterInterface;
use Illuminate\Console\Command;

class UpdateConverterDataBase extends Command
{
    const DEFAULT_CONVERTER = 'OER';
    private ConverterUpdaterFactory $converterUpdaterFactory;
    public function __construct(ConverterUpdaterFactory $converterUpdaterFactory)
    {
        $this->converterUpdaterFactory = $converterUpdaterFactory;
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'converter:update {converterType?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновляет базу в соответствиии с вызванным апи';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $args = $this->arguments();
        /** @var ConverterUpdaterInterface $converter */
        $converter = $this->converterUpdaterFactory->create(ConverterUpdaterInterface::ConverterPointer[$args['converterType'] ?? self::DEFAULT_CONVERTER]);
        $converter->updateConverterInfo();
        $forexCost = new ForexCost();
        $forexCost->forex_cost_array = json_encode($converter->getForexCostArray());
        $forexCost->main_forex = $converter->getMainForex();
        $forexCost->save();  //TODO разобраться почему данные не сохраняются в базу данных
        return Command::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\ForexCostActual;
use App\Service\Converter\Converters\ConverterUpdaterFactory;
use App\Service\Converter\ConverterUpdaterInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateConverterDataBase extends Command
{
    public function __construct(private readonly ConverterUpdaterFactory $converterUpdaterFactory)
    {
        parent::__construct();
    }

    protected $signature = 'converter:update {--type=1}';

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
            ->create(ConverterUpdaterInterface::CONVERTER_POINTER[(int)$convertType]);

        $converter->updateConverterInfo();

        DB::beginTransaction();

        try {
            foreach ($converter->getForexCostToSave() as $forexCost) {
                ForexCostActual::query()->updateOrCreate($forexCost);
            }
        } catch (RuntimeException $exception) {
            DB::rollBack();
            $this->error($exception->getMessage());

            return CommandAlias::FAILURE;
        }

        DB::commit();

        return CommandAlias::SUCCESS;
    }
}

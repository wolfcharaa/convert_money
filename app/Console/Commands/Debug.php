<?php

namespace App\Console\Commands;

use App\Models\ForexCostActual;
use App\Service\Converter\Conversion;
use App\Service\Converter\ConverterUpdaterInterface;
use Illuminate\Console\Command;

class Debug extends Command
{

    private Conversion $converter;

    public function __construct(Conversion $converter)
    {
        $this->converter = $converter;
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $number = 3;
        if (!array_key_exists($number, ConverterUpdaterInterface::CONVERTER_POINTER)) {
            print("Not found {$number} from " . ConverterUpdaterInterface::class);
            return Command::FAILURE;
        }

        $type = ConverterUpdaterInterface::CONVERTER_POINTER[$number];
        print_r("\n{$type}\n\n");
        return Command::SUCCESS;
    }
}

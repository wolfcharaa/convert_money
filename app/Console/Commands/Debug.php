<?php

namespace App\Console\Commands;

use App\Models\ForexCost;
use App\Service\Converter\Conversion;
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

        print($this->converter->convertForex('USD', 'EUR', 1));
        return Command::SUCCESS;
    }
}

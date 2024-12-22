<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Livewire\LinkChecker;

class CheckLinkStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'link:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the status of a specified link and notify subscribers.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Create an instance of the Livewire component to use its methods
        $linkChecker = new LinkChecker();

        // Perform the link check and send notifications if necessary
        $linkChecker->checkLink();

        // Provide feedback in the console
        $this->info('Link status checked and subscribers notified if necessary.');

        return Command::SUCCESS;
    }
}

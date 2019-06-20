<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

/**
 * Команда высылает админу на почту отчет о количестве посещений сайта
 *
 * Class SendVisitsReport
 * @package App\Console\Commands
 */
class SendVisitsReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-visits-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Отправка очета о количестве посещений сайта';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = date('d.m.Y');
        $visitsCount = rand(0, 1000000);

        Mail::send('mail.visits-report', ['date' => $date, 'visitsCount' => $visitsCount], function (Message $message) {
            $message->subject('Отчет о количестве посещений сайта')
                ->to(config('app_custom.admin.email'));
        });
    }
}

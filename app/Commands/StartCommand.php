<?php

namespace App\Commands;

use App\Helpers\BotMenu as BotMenuHelper;
use App\Models\BotMenu;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * Class HelpCommand.
 */
class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'start';

    /**
     * @var array Command Aliases
     */
    protected $aliases = ['listcommand'];

    /**
     * @var string Command Description
     */
    protected $description = 'Команды управления ботом';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $update = Telegram::getWebhookUpdates();

        //mainmenu()
        BotMenuHelper::mainMenu($update);
    }
}

<?php

namespace Norbis\AdvancedLog\Log;

use Monolog\Handler\TelegramBotHandler;
use Monolog\Logger as Monolog;
use Norbis\AdvancedLog\Log\Formatter\TelegramFormatter;

/**
 * Class LogManager.
 */
class LogManager extends \Illuminate\Log\LogManager
{
    /**
     * Create an instance of the Telegram log driver.
     *
     * @param array $config
     *
     * @return \Psr\Log\LoggerInterface
     */
    protected function createTelegramDriver(array $config)
    {
        $config['formatter'] = $config['formatter'] ?? TelegramFormatter::class;

        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(new TelegramBotHandler(
                $config['apiKey'],
                $config['channel'],
                $this->level($config),
                $config['bubble'] ?? true,
                $config['parseMode'] ?? 'HTML',
                $config['disableWebPagePreview'] ?? false,
                $config['disableNotification'] ?? false,
            ), $config),
        ]);
    }
}

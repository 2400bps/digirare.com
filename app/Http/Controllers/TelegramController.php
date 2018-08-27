<?php

namespace App\Http\Controllers;

use Curl\Curl;
use Carbon\Carbon;
use Telegram\Bot\Api;

class TelegramController extends Controller
{
    /**
     * Curl
     *
     * @var \Curl\Curl
     */
    protected $curl;

    /**
     * Telegram
     *
     * @var \Telegram\Bot\Api
     */
    protected $telegram;

    /**
     * BotController constructor.
     *
     * @param \Telegram\Bot\Api  $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->curl = new Curl();
        $this->curl->setHeader('Content-Type', 'application/json');
        $this->telegram = $telegram;
    }

    /**
     * Handles incoming webhook updates from Telegram.
     *
     * @return string
     */
    public function webhookHandler()
    {
        // Get Update
        $update = $this->telegram->commandsHandler(true);

        // Get Message
        $message = $update->getMessage();

        try
        {
            // Bot Analytics
            $response = $this->botAnalytics($message);

            \Log::info(serialize($response->response));
        }
        catch(\Throwable $e)
        {
            \Log::info($e->getMessage());
        }

        return 'Ok';
    }

    /**
     * Bot Analytics
     *
     * @param  mixed  $message
     * @return array
     */
    private function botAnalytics($message)
    {
        // Incoming Message
        $route = 'https://tracker.dashbot.io/track?platform=generic&v=9.9.1-rest&type=incoming&apiKey=' . config('digirare.bot_akey');

        // Get Message Intent
        $intent = $this->getIntent($message->getText());

        // Get Platform JSON
        $platformJson = $this->getPlatformJson($message->getChat());

        // Get Platform User JSON
        $platformUserJson = $this->getPlatformUserJson($message->getFrom());

        // Build Data Array
        $data = [
            'text' => $message->getText(),
            'userId' => $message->getFrom()->getId(),
            'intent' => $intent,
            'platformJson' => $platformJson,
            'platformJson' => $platformUserJson,
        ];

        return $this->curl->post($route, $data);
    }

    /**
     * Get Intent
     * 
     * @param  string $text
     * @return mixed
     */
    private function getIntent($text)
    {
        $intent = new stdClass;
        $intent->name = $this->getName($text);

        return $intent;
    }

    /**
     * Get Name
     * 
     * @param  string $text
     * @return array
     */
    private function getName($text)
    {
        $commands = ['/c', '/f', '/i'];
        $command = substr($text, 0, 2);

        if(in_array($command, $commands))
        {
            $command = strtoupper(substr($command, -1));

            return "{$command}_QUERY";
        }

        return 'NotHandled';
    }

    /**
     * Get Platform Json
     * 
     * @param  mixed $chat
     * @return object
     */
    private function getPlatformJson($chat)
    {
        $platform = new stdClass;
        $platform->chat = $chat;

        return $platform;
    }

    /**
     * Get Platform User Json
     * 
     * @param  mixed $from
     * @return object
     */
    private function getPlatformUserJson($from)
    {
        $user = new stdClass;
        $user->from = $from;

        return $user;
    }
}
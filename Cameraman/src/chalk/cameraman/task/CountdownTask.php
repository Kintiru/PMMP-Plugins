<?php

/**
 * @author ChalkPE <amato0617@gmail.com>
 * @since 2015-06-24 20:50
 */

namespace chalk\cameraman\task;

use chalk\cameraman\Cameraman;
use pocketmine\Player;
use pocketmine\scheduler\PluginTask;

class CountdownTask extends PluginTask {
    /** @var Player */
    private $player;

    /** @var callable */
    private $callback;

    /** @var string */
    private $message;

    /** @var int */
    private $countdown;

    /**
     * @param Player $player
     * @param callable $callback
     * @param string $message
     * @param int $countdown
     */
    function __construct(Player $player, callable $callback, $message, $countdown = 3){
        parent::__construct(Cameraman::getInstance());

        $this->player = $player;
        $this->countdown = $countdown;
        $this->callback = $callback;
    }

    /**
     * @param $currentTick
     */
    public function onRun($currentTick){
        if(--$this->countdown <= 0){
            $this->getOwner()->getServer()->getScheduler()->cancelTask($this->getTaskId());

            call_user_func($this->callback);
            return;
        }

        Cameraman::getInstance()->sendMessage($this->player, str_replace("%countdown%", $this->countdown, $this->message));
    }

    /**
     * @return Player
     */
    public function getPlayer(){
        return $this->player;
    }
}
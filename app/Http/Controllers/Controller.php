<?php

namespace App\Http\Controllers;

use function config;
use function count;
use function env;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Ixudra\Curl\Facades\Curl;
use function json_encode;
use function rand;
use function sizeof;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $hookSlack;
    function notifySlack($text = 'Empty text',$channel = '#debug',$name = "GoneBee"){
        $emoji = array(":monkey_face:",":ghost:");
        $params = array(
            "text"=> $text,
            "channel" => $channel,
            "username" => $name,
            "icon_emoji" => $emoji[rand(0,count($emoji) -1)]
        );
        Curl::to($this->getHookSlack())
            ->withHeader('Content-type: application/json')
            ->withData($params)
            ->asJson(true)
            ->post();
    }

    /**
     * @return mixed
     */
    public function getHookSlack ()
    {
        return $this->hookSlack = env('SLACK_WEBHOOK_URL');
    }

    /**
     * @param mixed $hookSlack
     */
    public function setHookSlack ($hookSlack)
    {
        $this->hookSlack = $hookSlack;
    }



}

<?php

namespace app\commands;

use app\models\Accesslog;
use DateTime;
use yii\console\Controller;
use yii\console\ExitCode;

class AddlogController extends Controller
{
    public $ip;
    public $date;
    public $url;
    public $userAgent;
    public $os;
    public $architecture;
    public $browser;

    public function options($actionID)
    {
        return [
            'ip',
            'date',
            'url',
            'os',
            'architecture',
            'browser'
            ];
    }

    public function optionAliases()
    {
        return [
            'ip' => 'ip',
            'date' => 'date',
            'url' => 'url',
            'os' => 'os',
            'arch' => 'architecture',
            'browser' => 'browser'
            ];
    }


    public function actionIndex(){
        $accesslog = new Accesslog();
        $accesslog->ip_address = $this->ip;
        $accesslog->request_at = (new DateTime('now'))->format('Y-m-d H:i:s');
        $accesslog->url = $this->url;
        $accesslog->os = $this->os;
        $accesslog->architecture = $this->architecture;
        $accesslog->browser = $this->browser;
        $saved = $accesslog->save();
        if ($saved == false) {
            echo "Возникла проблема!\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }
        echo "Данные успешно добавлены в таблицу accesslog!\n";
        return ExitCode::OK;
    }
}
<?php

class PLC
{
    private $ip;

    const LIGHTTYPE = ['stoboard' => 112, 'card_reader' => 113, 'collision_warning' => 114];
    const POWERTYPE = ['xps1' => 311, 'xps2' => 312, 'card_reader' => 313, 'camera' => 314, 'screen' => 315, 'touch' => 316, 'router' => 317, 'atur' => 318];
    const FANTYPE = ['into1' => 410, 'into2' => 411, 'exhaust1' => 412, 'exhaust2' => 413, 'exhaust3' => 414];

    public function __construct($ip)
    {
        $this->ip = "{$ip}:8080/MPCmd=";
    }

    /**
     * 搜尋各類型燈號狀態
     *
     * @return void
     */
    public function searchLightStatus($type)
    {
        $cmd = array_get(self::LIGHTTYPE, $type, 113);
        $url = sprintf("{$this->ip}%s",$cmd);
        $response = $this->sendGetRequest($url);
        if($response[$cmd]['_res']) {
            /**
             * 回應格式
             * L: 燈組編號：2站牌燈、3讀卡機燈、4防撞警示燈
             * M: 0直接執行、1自動執行(依照指定的時間區段)
             * S: 動作類型：0關、1開、2閃爍
             * TTTTTTTT: 時間區段數值： 00002400(00:00~24:00)
             */
            $output =  $response[$cmd]['response']['syntax'];
            list($start_time, $end_time) = str_split($output['TTTTTTTT'],4);
            $response = [
                'launch'        => (int) $output['M'],
                'action'        => (int) $output['S'],
                'start_time'    => implode(":",str_split($start_time,2)),
                'end_time'      => implode(":",str_split($end_time,2)),
            ];
        } else {
            $response = [];
        }

        return $response;
    }

    /**
     * 搜尋門位狀態
     *
     * @return void
     */
    public function searchDoorStatus()
    {
        $cmd = 20;
        $url = sprintf("{$this->ip}%s",$cmd);
        $response = $this->sendGetRequest($url);
        if($response[$cmd]['_res']) {
            /**
             * 回應格式
             * A: 外門門鎖門狀態。 0鎖定、1開啟
             * B: 外門門位狀態。 0鎖定、1開啟
             * C: 內門門門位狀態。 0鎖定、1開啟
             * D: 外電源插座門狀態。 0鎖定、1開啟
             */
            $output = $response[$cmd]['response']['syntax'];
            $response = [
                'outside_lock_door_status' => (int) $output['A'],
                'outside_door_status' => (int) $output['B'],
                'inside_door_status' => (int) $output['C'],
                'outside_door_power_socket_status' => (int) $output['D'],
            ];
        } else {
            $response = [];
        }

        return $response;
    }

    /**
     * 搜詢各類型的電源狀態
     *
     * @return void
     */
    public function searchPowerStatus($type)
    {
        $cmd = array_get(self::POWERTYPE, $type, 311);
        $url = sprintf("{$this->ip}%s",$cmd);
        $response = $this->sendGetRequest($url);
        if($response[$cmd]['_res']) {
            /**
             * 回應格式
             * P: 電源埠號。1xps1、2xps2 ....
             * F: 運作狀態。 0關、1開、2重置(off->等5秒->on)
             */
            $output = $response[$cmd]['response']['syntax'];
            $response = (int) $output['F'];
        } else {
            $response = [];
        }

        return $response;
    }

    /**
     * 搜詢各類型的風扇狀態
     *
     * @return void
     */
    public function searchFanStatus($type)
    {
        $cmd = array_get(self::FANTYPE, $type, 410);
        $url = sprintf("{$this->ip}%s",$cmd);
        $response = $this->sendGetRequest($url);
        if($response[$cmd]['_res']) {
            /**
             * 回應格式
             * F: 風扇編號。0進風1、2排風1 ....
             * M: 啟動設定類別。 0直接執行、1自動執行
             * S: 目前的狀態。 0停止運轉、1運轉中
             * HH: 目前設定的自動啟動風扇的溫度00~99(攝氏溫度C)
             * LL: 目前設定的自動關閉風扇的溫度00~99(攝氏溫度C)
             */
            $output = $response[$cmd]['response']['syntax'];
            $response = [
                'launch'            => (int) $output['M'],
                'action'            => (int) $output['S'],
                'open_temperature'  => (int) $output['HH'],
                'close_temperature' => (int) $output['LL'],
            ];
        } else {
            $response = [];
        }

        return $response;
    }

    /**
     * 控制kiosk狀態
     *
     * @param string $cmd
     * @return void
     */
    public function controlStatus($cmd)
    {
        $url = sprintf("{$this->ip}%s",$cmd);
        $response = $this->sendGetRequest($url);
        return $response[$cmd]['_res'];
    }

    private function sendGetRequest($url)
    {
        // 執行
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $response = str_replace("\n", "" , curl_exec($ch));
        // 將回應處理為json格式
        if(!preg_match("/^\{/", $response)) {
            $response = "{{$response}";
        }
        // 系統資訊
        $info = curl_getinfo($ch); 
        // 檢查是否有錯誤發生
        if (curl_errno($ch)) {
    		$error_msg = "网址:{$url}，错误代号:".curl_errno($ch). '错误讯息:'.curl_error($ch);
            // 丟例外處理(throw exception)
            return errorOutput($error_msg);
    	}
        // 關閉
        curl_close($ch);

        return json_decode($response, true);
    }
}
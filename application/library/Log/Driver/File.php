<?php
class Log_Driver_File
{

    protected $config = [
        'time_format' => ' c ',
        'single' => false,   // 单日志
        'apart_level' => [],
        'file_size' => 2097152,
        'path' => '',
    ];

    protected $writed = [];

    public function __construct($config = [])
    {
        $this->config['path'] = APPLICATION_PATH . '/runtime/log/';
        $this->config = array_merge($this->config, $config);
    }

    /**
     * 日志写入接口
     * @param array $log
     * @return bool|void
     */
    public function save(array $log = [])
    {
        if ($this->config['single']) {
            $destination = $this->config['path'] . 'single';
        } else {
            $destination = $this->config['path'] . date('Ym') . '/' . date('d') . '.log';
        }
        $path = dirname($destination);
        // var_dump($path);exit;
        !is_dir($path) && mkdir($path, 0755, true);

        $info = '';
        foreach ($log as $type => $val) {
            $level = '';
            foreach ($val as $msg) {
                if (!is_string($msg)) {
                    $msg = var_export($msg, true);
                }
                $level .= '[ ' . $type . ' ] ' . $msg . "\r\n";
            }
            if (in_array($type, $this->config['apart_level'])) {
                // 独立记录的日志级别
                if ($this->config['single']) {
                    $filename = $path . '/' . $type . '.log';
                } else {
                    $filename = $path . '/' . date('d') . '_' . $type . '' . '.log';
                }
                $this->write($level, $filename, true);
            } else {
                $info .= $level;
            }
        }

        if ($info) {
            return $this->write($info, $destination);
        }
        return true;
    }

    protected function write( $message, $destination, $apart = false )
    {
        //检测日志文件大小，超过配置大小则备份日志文件重新生成
        if( is_file($destination) && floor($this->config['file_size']) <= filesize($destination) ) {
            try {
                rename($destination, dirname($destination) . '/' . time() . '-' . basename($destination));
            } catch (\Exception $e) {
            }
            $this->writed[$destination] = false;
        }

        if( empty($this->writed[$destination]) ) {
            if( Yaf_Registry::get('config')->application->debug ) {
                // 获取基本信息
                if( isset( $_SERVER['HTTP_HOST'] ) ) {
                    $current_uri = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                } else {
                    $current_uri = "cmd:" . implode( ' ', $_SERVER['argv'] );
                }
                $runtime = round( microtime( true ) - microtime(true), 10 );
                $reqs       = $runtime > 0 ? number_format(1 / $runtime, 2) : '∞';
                $time_str   = ' [运行时间：' . number_format($runtime, 6) . 's][吞吐率：' . $reqs . 'req/s]';
                $memory_use = number_format((memory_get_usage() - memory_get_usage()) / 1024, 2);
                $memory_str = ' [内存消耗：' . $memory_use . 'kb]';
                $file_load  = ' [文件加载：' . count(get_included_files()) . ']';

                $message = '[ info ] ' . $current_uri . $time_str . $memory_str . $file_load . "\r\n" . $message;
            }
            $now     = date($this->config['time_format']);
            $ip      = Common_Request::ip();
            $method  = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'CLI';
            $uri     = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
            $message = "---------------------------------------------------------------\r\n[{$now}] {$ip} {$method} {$uri}\r\n" . $message;

            $this->writed[$destination] = true;

        }

        return error_log($message, 3, $destination);

    }

}
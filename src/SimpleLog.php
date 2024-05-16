<?php

namespace EoProger\SimpleLog;

/*
 * Класс Logger для логирования
 * Вызов - Logger::newLog('log')->log($some_info);
 * Где 'log' - название файла, а $some_info - информация для логирования, которая будет записана в файл log.log
 * */

class SimpleLog
{
    protected static $PATH = __DIR__ ;
    protected $name;
    protected $fp;

    public function __construct($name)
    {
        $this->name = $name;
        $this->open();
    }

    public function open()
    {
        $this->fp = fopen(self::$PATH . '/' . $this->name . '.log', 'a+');
    }

    public static function newLog($name)
    {
        return new SimpleLog($name);
    }

    public function log($message)
    {
        if (!is_string($message)) {
            $this->logPrint($message);
            return;
        }
        $log = '';
        $log .= '[' . date('D M d H:i:s Y', time()) . '] ';
        $log .= $message;
        $log .= "\n";
        $this->_write($log);
    }

    public function logPrint($obj)
    {
        ob_start();
        print_r($obj);
        $ob = ob_get_clean();
        $this->log($ob);
    }

    protected function _write($string)
    {
        fwrite($this->fp, $string);
    }

    public function __destruct()
    {
        fclose($this->fp);
    }
}
<?php
/**
 * Created Kudin Dmitry
 * Date: 09.10.2017
 * Time: 15:04
 */

namespace common\components;

use Yii;
use yii\base\ErrorException;

class Logger
{
    /**
     * @var boolean is debug enabled or not
     */
    public $isDebug;

    /**
     * @var string path to log file
     */
    public $logFile;

    /**
     * @param boolean $isDebug
     * @param string $logFile
     */
    public function __constructor($isDebug, $logFile)
    {
        $this->isDebug = $isDebug;
        $this->logFile = $logFile;
    }

    /**
     * Logging the debugging information to "debug.log"
     *
     * @param  string $message
     * @return boolean
     */
    public function logToFile($message)
    {
        if (empty($this->logFile)) return false;

        if ($this->isDebug) {
            $line = '[' . date('Y-m-d H:i:s') . '] :: ' . $message;
            try {
                $file = fopen($this->logFile, 'a+');
                fwrite($file, $line . PHP_EOL);
                fclose($file);
            } catch (ErrorException  $ex) {
                return false;
            }
        }
        return true;
    }

    /**
     * Logging the debugging information
     *
     * @param  string $message
     * @return boolean
     */
    public function log($message)
    {
        Yii::warning($message);

        return $this->logToFile($message);
    }
}
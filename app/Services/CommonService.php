<?php

/**
 * A Service for Common context
 */

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

/**
 * [Description CommonService]
 */
class CommonService
{

    /**
     * Log object
     *
     * @var object
     */
    private $_logger;

    /**
     * [Description for $loggerDefaultMessage]
     *
     * @var [type]
     */
    private $loggerDefaultMessage;

    private $results;

    /**
     * [Description for __construct]
     *
     * @param Log $logger
     *
     */
    public function __construct(Log $_logger)
    {
        $this->_logger = $_logger;
        $this->loggerDefaultMessage = 'Info';
        //$this->results = null;
    }

    public function createID(): string
    {
        $this->results = Uuid::uuid7();
        return $this->results;
    }

    public function createIDTimestamp(): string
    {
        $this->results = date('YmdHis');
        return $this->results;
    }

    public function createUUID(): string
    {
        $this->results = Uuid::uuid7();
        return $this->results;
    }

    /**
     * Set Logger
     *
     * @param string $type
     * @param string|null $message
     * @param array $context
     *
     * @return void
     *
     */
    public function setLogger(
        string $type = 'info', string $message = null, array $context = []
    ): void {

        switch ($type) {

        case 'alert':
            $this->_logger::alert($message, $context);
            break;

        case 'debug':
            $this->_logger::debug($message, $context);
            break;

        case 'error':
            $this->_logger::error($message, $context);
            break;

        case 'info':
        default:
            $this->_logger::info($message, $context);

            break;
        }

    }

}

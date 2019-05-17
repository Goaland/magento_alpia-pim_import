<?php
namespace Goalandfrance\AlpiaImport\Cron;

use Goalandfrance\AlpiaImport\Helper\Api\Api;
use Magento\Framework\App\Cron;

class Import extends Cron
{
    /**
     * @var Api
     */
    private $api;

    public function __construct(
            Api $api
    )
    {
        $this->api = $api;
    }

    public function execute()
    {
        $this->api->export();
    }
}

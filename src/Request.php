<?php declare(strict_types=1);

namespace openapitest;

use Psr\Http\Message\RequestInterface;

class Request extends \GuzzleHttp\Psr7\Request implements RequestInterface {}
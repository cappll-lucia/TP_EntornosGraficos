<?php

use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    protected $proxies = '*'; // Confía en todos los proxies

    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}

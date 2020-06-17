<?php

use Illuminate\Support\Str;

function generateToken() {
    return base64_encode(json_encode(array('time' => time(), 'hash' => Str::random(32))));
}

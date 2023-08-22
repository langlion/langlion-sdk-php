<?php

namespace LangLion\SDK;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\UriFactoryInterface;

interface HttpFactoryInterface extends RequestFactoryInterface,
ResponseFactoryInterface,
ServerRequestInterface,
StreamFactoryInterface,
UploadedFileInterface,
UriFactoryInterface
{

}
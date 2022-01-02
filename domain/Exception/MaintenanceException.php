<?php

namespace Domain\Exception;

use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class MaintenanceException extends ServiceUnavailableHttpException
{

}
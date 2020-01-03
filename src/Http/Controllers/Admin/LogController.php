<?php

namespace PbbgIo\Titan\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

class LogController extends LogViewerController
{
    protected $view_log = 'titan::admin.logs.index';
}

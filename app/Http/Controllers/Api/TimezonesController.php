<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Timezones API controller.
 *
 * @version 2.0.0
 * @author  Gustavo Straube <gustavo@straube.co>
 */
class TimezonesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): array
    {
        return DateTimeZone::listIdentifiers();
    }

    public function search(Request $request): ?string
    {
        $timezone = null;
        try {
            $response = Http::get('http://ip-api.com/json/' . $request->ip());
            $data = $response->json();
            $timezone = $data['timezone'];
        } catch (Exception $e) {
            Log::debug($e);
        }
        return $timezone;
    }
}

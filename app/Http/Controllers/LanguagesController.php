<?php

namespace App\Http\Controllers\API;

use App\Actions\Success;
use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api')->except('index', 'show', 'setLanguage', 'getLanguage', 'getDictionary');
    }
    
    public function index(): JsonResponse
    {
        $data = Language::all();
        
        return Success::execute(['data' => $data]);
    }

    public function getDictionary(Request $request)
    {
        $files   = glob(resource_path('lang/' . app()->getLocale() . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $strings[$name] = require $file;
        }
        
        return Success::execute(['data' => $strings]);
    }

    public function setLanguage($locale)
    {
        app()->setLocale($locale);

        $language = Language::where('name', $locale)->first();

        return Success::execute(['data' => $language]);
    }

    public function getLanguage()
    {
        return Success::execute(['data' => app()->getLocale()]);
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\UserSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserSettingsController extends Controller
{
    public function updateLanguage(Request $request): RedirectResponse
    {
        $request->validate([
            'language' => ['required', 'string', Rule::in(['pl', 'en'])],
        ]);

        $user = Auth::user();
        
        UserSettings::updateOrCreate(
            ['user_id' => $user->id],
            ['language' => $request->language]
        );

        // Set locale for current session
        app()->setLocale($request->language);
        session(['locale' => $request->language]);

        return back()->with('status', __('ui.settings.language_updated'));
    }
}

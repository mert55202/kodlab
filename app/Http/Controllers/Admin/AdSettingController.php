<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdSetting;
use Illuminate\Http\Request;

class AdSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function index()
    {
        $settings = AdSetting::first();
        if (!$settings) {
            $settings = AdSetting::create([
                'ads_enabled' => false,
                'show_in_header' => false,
                'show_in_sidebar' => false,
                'show_in_lesson' => false,
                'show_in_quiz' => false,
                'hide_for_premium' => true,
            ]);
        }
        return view('admin.ads.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'adsense_publisher_id' => 'nullable|string|max:255',
            'ads_enabled' => 'boolean',
            'show_in_header' => 'boolean',
            'show_in_sidebar' => 'boolean',
            'show_in_lesson' => 'boolean',
            'show_in_quiz' => 'boolean',
            'hide_for_premium' => 'boolean',
            'ad_slot_header' => 'nullable|string|max:255',
            'ad_slot_sidebar' => 'nullable|string|max:255',
            'ad_slot_lesson' => 'nullable|string|max:255',
        ]);

        $settings = AdSetting::first();
        if ($settings) {
            $settings->update($data);
        }

        return redirect()->route('admin.ads.index')->with('success', 'Reklam ayarları güncellendi.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemsController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function create(Request $request) {
        // Validate
        $fields = $request->validate([
            'item_name' => ['required', 'max:255'],
            'item_description' => ['required', 'max:255'],
            'item_status' => ['required'],
            'item_type' => ['required'],
            'item_pic' => ['nullable', 'image', 'max:2048'], // File validation
            'latitude' => ['required'],
            'longitude' => ['required'],
            'reported_date' => ['required', 'date'],
            'reported_time' => ['required', 'date_format:H:i'],
        ]);

        // Handle the upload
        if ($request->hasFile('item_pic')) {
            $fields['item_pic'] = Storage::disk('public')->put('items', $request->item_pic);
        }

        // Add the authenticated user's ID
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('dashboard')->withErrors(['error' => 'User not authenticated']);
        }

        \Log::info('Authenticated user ID:', ['user_id' => $userId]); // Log the user ID

        $fields['user_id'] = $userId;

        \Log::info('Fields:', $fields); // Log the fields to be inserted

        // Create Item
        Item::create($fields);

        // Redirect
        return redirect()->route('dashboard')->with('greet', 'You have reported a new item');
    }
}

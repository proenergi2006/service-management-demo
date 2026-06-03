<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class PublicAssetController extends Controller
{
    public function show($qr_code)
{
    $asset = Asset::with([
        'category',
        'location',
        'activeAssignment.user',
        'documents',
    ])->where('qr_code', $qr_code)->firstOrFail();

    return view('assets.public-scan', compact('asset'));
}
}
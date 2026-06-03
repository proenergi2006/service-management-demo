<?php

namespace App\Http\Controllers;

use App\Models\GuestVisit;
use Illuminate\Http\Request;

class GuestVisitController extends Controller
{
    public function publicForm()
    {
        return view('guest.public-checkin');
    }

    public function storePublic(Request $request)
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:150',
            'company_name' => 'nullable|string|max:150',
            'phone' => 'nullable|string|max:50',
            'host_name' => 'nullable|string|max:150',
            'purpose' => 'nullable|string|max:255',
            'branch' => 'required|string|max:100',
            'vehicle_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        GuestVisit::create([
            ...$validated,
            'guest_code' => $this->generateGuestCode(),
            'checkin_at' => now(),
            'status' => 'checked_in',
        ]);

        return redirect()
            ->route('guest.thank-you')
            ->with('success', 'Check-in tamu berhasil.');
    }

    public function thankYou()
    {
        return view('guest.thank-you');
    }

    public function index(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        $status = $request->get('status', '');

        $query = GuestVisit::whereDate('checkin_at', $date)->latest('checkin_at');

        if ($status !== '') {
            $query->where('status', $status);
        }

        $guests = $query->paginate(15)->withQueryString();

        return view('guest.index', compact('guests', 'date', 'status'));
    }

    public function checkout(GuestVisit $guest)
    {
        if ($guest->status === 'checked_out') {
            return back()->with('error', 'Tamu sudah checkout.');
        }

        $guest->update([
            'checkout_at' => now(),
            'status' => 'checked_out',
        ]);

        return back()->with('success', 'Tamu berhasil checkout.');
    }

    private function generateGuestCode(): string
    {
        $date = now()->format('Ymd');
        $count = GuestVisit::whereDate('created_at', now())->count() + 1;

        return 'GST-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
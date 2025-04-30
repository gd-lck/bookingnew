<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Jadwal;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Payment; 
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;


class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user','karyawan','layanan','payment','booking_time'])->paginate(10);

        return view('admin.Booking.index', compact('bookings'));
    }

    public function userBooking()
    {
    $bookings = Booking::with(['layanan', 'karyawan', 'payment'])
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate(5);
    return view('customer.userBooking', compact('bookings'));
    }

    public function create(Request $request, $layanan_id = null)
    {
        $layanans = Layanan::all();
        $layananTerpilih = $layanan_id ? Layanan::find($layanan_id) : null;
        return view('customer.booking', compact('layanans', 'layananTerpilih'));
    }

  
    public function store(Request $request)
    {   
        $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'karyawan_id' => 'required|exists:karyawans,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|date_format:H:i',
        ]);
        
        //penggabungan tanggal
        $datetime = Carbon::parse($request->booking_date . ' ' . $request->booking_time);
        
       
        $layanan = Layanan::findOrFail($request->layanan_id);
        $durasi = (float)$layanan->durasi; 
        
     
        $bookingEnd = $datetime->copy()->addMinutes($durasi);  
    
        // bagian waktu (jam:menit:detik) 
        $bookingStartTime = $datetime->format('H:i:s');
        $bookingEndTime = $bookingEnd->format('H:i:s');
        
        $bookingStartTime = $datetime->format('H:i:s');
        Log::info('Booking start time: ' . $bookingStartTime);
        
        $userId = Auth::id();
        $booking = Booking::create([
            'user_id' => $userId,
            'karyawan_id' => $request->karyawan_id,
            'layanan_id' => $request->layanan_id,
            'booking_time' => $datetime,
            'booking_start' => $bookingStartTime, 
            'booking_end' => $bookingEndTime,     
            'status' => 'pending'
        ]);
    
      
        $layanan = $booking->layanan;
        $user = $booking->user;
        
      
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $layanan->harga,
            'payment_status' => 'unpaid',
            'payment_method' => 'qris',
        ]);
        //konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = config('services.midtrans.is_sanitized', true);
        Config::$is3ds = config('services.midtrans.is_3ds', true);
    
        // Persiapan data snap 
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $booking->id,  
                'gross_amount' => $layanan->harga,     
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email
            ],
            'item_details' => [[
                'id' => $layanan->id,
                'price' => $layanan->harga,
                'quantity' => 1,
                'name' => $layanan->nama_layanan
            ]]
        ];
    
        
        $snapToken = Snap::getSnapToken($params);
    
    
        return view('customer.payment', compact('snapToken', 'booking'));
    }
    

    public function webhook(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        Log::info('Webhook Payload:', $data);

        $orderId = $data['order_id'] ?? null;
        $transactionStatus = $data['transaction_status'] ?? null;

        if (!$orderId) {
            Log::warning("Webhook ignored: Missing order_id");
            return response()->json(['message' => 'Ignored, no order_id'], 200);
        }

        if (!str_starts_with($orderId, 'ORDER-')) {
            Log::info("Webhook for non-booking order_id $orderId");
            return response()->json(['message' => 'Ignored, not our booking order'], 200);
        }

        $bookingId = str_replace('ORDER-', '', $orderId);
        $booking = Booking::with('payment')->find($bookingId);

        if (!$booking) {
            Log::warning("Booking ID $bookingId not found for order_id $orderId");
            return response()->json(['message' => 'Booking not found'], 200);
        }

        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            $booking->status = 'booked';
            if ($booking->payment) {
                $booking->payment->payment_status = 'paid';
                $booking->payment->payment_date = now();
                $booking->payment->save();
            }
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $booking->status = 'canceled';
            if ($booking->payment) {
                $booking->payment->payment_status = 'failed';
                $booking->payment->save();
            }
        }

        $booking->save();

        Log::info("Booking ID $bookingId updated successfully with status $transactionStatus");
        return response()->json(['message' => 'Webhook processed'], 200);
    }

    public function payBooking(Booking $booking)
        {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->payment && $booking->payment->payment_status === 'paid') {
            return redirect()->route('user.bookings')->with('message', 'Booking ini sudah dibayar.');
        }

      
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $user = $booking->user;
        $layanan = $booking->layanan;

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $booking->id,
                'gross_amount' => $layanan->harga,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email
            ],
            'item_details' => [[
                'id' => $layanan->id,
                'price' => $layanan->harga,
                'quantity' => 1,
                'name' => $layanan->nama_layanan
            ]]
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('customer.payment', compact('snapToken', 'booking'));
    }



    public function reschedule(Request $request, $id){

        $request -> validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|date_format:H:i',
        ]);
        $datetime = Carbon::parse($request->booking_date . ' ' . $request->booking_time);

        $layanan = Layanan::findOrFail($request->layanan_id);
        $durasi = (float)$layanan->durasi; 
        
        $bookingEnd = $datetime->copy()->addMinute($durasi);
        
        $bookingStartTime = $datetime->format('H:i:s');
        $bookingEndTime = $bookingEnd->format('H:i:s');

        $booking = Booking::findOrFail($id);

        $booking->karyawan_id = $request->karyawan_id;
        $booking->layanan_id = $request->layanan_id;
        $booking->booking_time = $datetime;
        $booking->booking_start = $bookingStartTime;
        $booking->booking_end = $bookingEndTime;

        $booking->save();

        return redirect(route('customer.userBooking'));
    }


    public function cariKaryawan(Request $request)
    {
        try {
            $tanggal = $request->tanggal;
            $jam = $request->jam;
    
            $layanan = Layanan::findOrFail($request->layanan_id);
            $bookingStart = Carbon::parse($tanggal . ' ' . $jam);
            // Misalnya $layanan->durasi adalah float (contoh: 60.0)
            $bookingEnd = Carbon::parse($bookingStart)->addMinutes((int)$layanan->durasi);  

    
            $jadwal = Jadwal::where('tanggal', $tanggal)
                ->where('jam_mulai', '<=', $jam)
                ->where('jam_selesai', '>=', $bookingEnd->format('H:i'))
                ->get();
    
            $karyawanShift = $jadwal->pluck('karyawan_id')->unique();
    
            $bookedKaryawan = Booking::where('booking_time', 'like', "$tanggal%")
                ->where(function ($query) use ($bookingStart, $bookingEnd) {
                    $query->where(function ($q) use ($bookingStart, $bookingEnd) {
                        $q->where('booking_start', '<', $bookingEnd)
                          ->where('booking_end', '>', $bookingStart);
                    });
                })->pluck('karyawan_id');
    
            $available = Karyawan::whereIn('id', $karyawanShift)
                ->whereNotIn('id', $bookedKaryawan)
                ->get(['id', 'nama']);
    
            return response()->json($available);
        } catch (\Exception $e) {
            Log::error('Error fetching available employees: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan saat memuat data karyawan.'], 500);
        }
    }
    
}

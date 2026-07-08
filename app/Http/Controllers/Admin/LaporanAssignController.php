<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Petugas;
use App\Models\Penugasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class LaporanAssignController extends Controller
{
    public function create(Laporan $laporan)
    {
        $petugas = Petugas::all();
        return view('admin.laporan.assign', compact('laporan', 'petugas'));
    }

    public function store(Request $request, Laporan $laporan)
    {
        // Debug: Lihat data yang masuk
        Log::info('Request Data:', $request->all());
        
        $request->validate([
            'petugas_id' => 'required|exists:petugas,id',
            'tanggal_tugas' => 'required|date|after_or_equal:today',
        ]);

        try {
            $penugasanId = null;

            DB::transaction(function () use ($request, $laporan, &$penugasanId) {
                // Update status laporan dan petugas_id
                $laporan->update([
                    'petugas_id' => $request->petugas_id,
                    'status'     => 'ditugaskan',
                ]);

                Log::info('Laporan Updated:', $laporan->toArray());

                // Simpan ke tabel penugasans
                $penugasan = Penugasan::create([
                    'laporan_id' => $laporan->id,
                    'petugas_id' => $request->petugas_id,
                    'tanggal_tugas' => $request->tanggal_tugas,
                    'status' => 'ditugaskan',
                ]);

                $penugasanId = $penugasan->id;
                Log::info('Penugasan Created:', $penugasan->toArray());
            });

            // Kirim Push Notification FCM ke Petugas
            $petugas = Petugas::find($request->petugas_id);
            if ($petugas && $petugas->fcm_token) {
                try {
                    $factory = (new Factory)
                        ->withServiceAccount(storage_path('app/firebase-auth.json'));
                    
                    $messaging = $factory->createMessaging();

                    $message = CloudMessage::new()
                        ->withToken($petugas->fcm_token)
                        ->withNotification(Notification::create('Tugas Baru Diterima!', 'Anda mendapatkan tugas perbaikan jalan: ' . $laporan->judul))
                        ->withData([
                            'tugas_id' => (string) $penugasanId,
                            'laporan_id' => (string) $laporan->id,
                        ]);

                    $messaging->send($message);
                    Log::info('FCM Notification sent to petugas_id: ' . $petugas->id);
                } catch (\Exception $e) {
                    Log::error('FCM Notification Error: ' . $e->getMessage());
                }
            }

            return redirect()
                ->route('laporan.show', $laporan->id)
                ->with('success', 'Petugas berhasil ditugaskan');
                
        } catch (\Exception $e) {
            Log::error('Error assigning petugas: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Gagal menugaskan petugas: ' . $e->getMessage());
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = Auth::user()->notifikasis()
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
        
        return view('notifikasi.index', compact('notifikasis'));
    }
    
    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())
                      ->findOrFail($id);
        
        $notifikasi->update(['is_read' => true]);
        
        if ($notifikasi->url) {
            return redirect($notifikasi->url);
        }
        
        return back();
    }
    
    public function markAllAsRead()
    {
        Auth::user()->notifikasis()->unread()->update(['is_read' => true]);
        
        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }
    
    public function destroy($id)
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())
                      ->findOrFail($id);
        
        $notifikasi->delete();
        
        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }
    
    public function getUnreadCount()
    {
        $count = Auth::user()->notifikasis()->unread()->count();
        
        if (request()->wantsJson()) {
            return response()->json(['count' => $count]);
        }
        
        return $count;
    }
}
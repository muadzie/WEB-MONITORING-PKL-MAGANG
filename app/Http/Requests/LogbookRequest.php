<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogbookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tanggal' => 'required|date|before_or_equal:today',
            'kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'dokumentasi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'tanggal.before_or_equal' => 'Tanggal tidak boleh melebihi hari ini',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter',
        ];
    }
}
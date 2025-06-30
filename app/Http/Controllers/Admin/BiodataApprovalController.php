<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biodata;

class BiodataApprovalController extends Controller
{
    public function approve($id)
    {
        $biodata = Biodata::where('user_id', $id)->firstOrFail();
        $biodata->is_approved = true;
        $biodata->save();

        return back()->with('success', 'Biodata berhasil disetujui.');
    }
}

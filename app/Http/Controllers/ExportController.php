<?php

namespace App\Http\Controllers;

use App\Models\Export;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exports = Export::paginate(5);

        return Inertia::render('Reports', [
            'exports' => $exports
        ]);
    }

    public function show($export)
    {
        $export = Export::find($export);

        return Storage::download($export->file_name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function destroy($export)
    {
        $export = Export::find($export);
        if($export) {
            Storage::delete($export->file_name);
            $export->delete();
        }
        return redirect()->back()
            ->with('success', 'Deletado com sucesso!');

    }
}

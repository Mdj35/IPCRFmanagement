<?php

namespace App\Http\Controllers;

use App\Models\Ipcrf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IpcrfController extends Controller
{
    public function index()
    {
        // Stats for the dashboard
        $totalUploaded = Ipcrf::count();
        $pendingReview = Ipcrf::where('status', 'Pending')->count();
        $completedToday = Ipcrf::whereDate('created_at', today())->where('status', '!=', 'Pending')->count();

        // Recent uploads
        $recentUploads = Ipcrf::latest()->take(10)->get();

        return view('encoderDashboard', compact('totalUploaded', 'pendingReview', 'completedToday', 'recentUploads'));
    }


    public function list()
    {
        $ipcrfs = Ipcrf::latest()->paginate(10);

        return view('index', compact('ipcrfs'));
    }

    public function create()
    {
        // Provinces data for the dropdowns
        $provinces = [
            [
                'name' => "Davao de Oro",
                'municipalities' => ["Compostela", "Laak", "Mabini", "Maco", "Maragusan", "Mawab", "Monkayo", "Montevista", "Nabunturan", "New Bataan", "Pantukan"]
            ],
            [
                'name' => "Davao del Norte",
                'municipalities' => ["Asuncion", "Braulio E. Dujali", "Carmen", "Kapalong", "New Corella", "San Isidro", "Santo Tomas", "Talaingod"]
            ],
            [
                'name' => "Davao del Sur",
                'municipalities' => ["Bansalan", "Hagonoy", "Kiblawan", "Magsaysay", "Malalag", "Matanao", "Padada", "Santa Cruz", "Sulop"]
            ],
            [
                'name' => "Davao Occidental",
                'municipalities' => ["Don Marcelino", "Jose Abad Santos", "Malita", "Santa Maria", "Sarangani"]
            ],
            [
                'name' => "Davao Oriental",
                'municipalities' => ["Baganga", "Banaybanay", "Boston", "Caraga", "Cateel", "Governor Generoso", "Lupon", "Manay, San Isidro", "Tarragona"]
            ]
        ];

        return view('wizard', compact('provinces'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'province' => 'required|string',
            'municipality' => 'required|string',
            'name' => 'required|string|max:255',
            'evaluated_file' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'scanned_file' => 'required|file|mimes:pdf,jpg,png|max:10240',
        ]);

        // Handle file uploads
        $evaluatedPath = $request->file('evaluated_file')->store('ipcrfs/evaluated');
        $scannedPath = $request->file('scanned_file')->store('ipcrfs/scanned');

        // Create the record
        $ipcrf = Ipcrf::create([
            'name' => $validated['name'],
            'province' => $validated['province'],
            'municipality' => $validated['municipality'],
            'evaluated_file_path' => $evaluatedPath,
            'scanned_file_path' => $scannedPath,
            'status' => 'Saved to Drive', // Simulating the "Save to Google Drive" step
        ]);

        // Simulate "Notify Admin" logic here (e.g., send email)
        Mail::to('lorence.maranga@hcdc.edu.ph')->send(new IpcrfUploaded($ipcrf));

        return redirect()->route('dashboard')->with('success', 'IPCRF uploaded successfully and Admin notified!');
    }
}

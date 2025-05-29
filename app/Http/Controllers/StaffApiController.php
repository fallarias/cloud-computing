<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Staff;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class StaffApiController extends Controller
{

    public function get_login() {

        return view("attendance.login");

    }

    public function attendance() {

        return view("attendance.staffAttendance");

    }

    public function dashboard() {

        $entries = DB::table('staff_entry')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(id) as count'))
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        // Map dates to month names (e.g., "May 2025")
        $labels = $entries->map(function($entry) {
            return Carbon::parse($entry->date)->format('M Y'); // "May 2025"
        })->toArray();

        $data = $entries->pluck('count')->toArray();

        return view('attendance.dashboard', compact('labels', 'data'));

    
    }

    public function registration(Request $request) {

        return view("attendance.staffRegistration");

    }

    public function attendance_in(Request $request)
    {
        $attrs = $request->validate([
            'id' => 'required',
        ]);
        if (strlen($attrs['id']) !== 6) {
            return redirect()->back()->with('message', 'The ID must be exactly 6 digits.');
        }        

        $staff = Staff::where('id_number', $attrs['id'])->first();
    
        if (!$staff) {
            return redirect()->back()->with('message', 'No staff found with the provided ID.');
        }

        Logs::create([
            'id_number' => $attrs['id'],
            'time_in' => now(),
        ]);  

        return redirect()->back()->with('success', 'Successfully Timed In.');
         
    }

    public function attendance_out(Request $request)
    {
        $attrs = $request->validate([
            'id' => 'required',
        ]);
        if (strlen($attrs['id']) !== 6) {
            return redirect()->back()->with('message', 'The ID must be exactly 6 digits.');
        }        

        $staff = Staff::where('id_number', $attrs['id'])->first();
    
        if (!$staff) {
            return redirect()->back()->with('message', 'No staff found with the provided ID.');
        }

        $entry = Logs::whereNotNull('time_in')
                        ->whereNull('time_out')
                        ->where('id_number', $attrs['id'])->first();

        if($entry){

            Logs::where('id_number', $staff->id_number)->where('id', $entry->id)->update([
                'time_out' => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'Successfully Timed Out.');
        }

        return redirect()->back()->with('message', 'Time in first before time out.');
        
         
    }

    public function entry(Request $request){

        $attrs = $request->validate([
            'id' => 'required',
            'first' => 'required',
            'middle' => 'required',
            'last' => 'required',
            'department' => 'required',
        ]);

        if (strlen($attrs['id']) !== 6) {
            return redirect()->back()->with('error', 'The ID must be exactly 6 digits.');
        }  

        if (preg_match('/[^a-zA-Z\s]/', $attrs['first']) || preg_match('/[^a-zA-Z\s]/', $attrs['middle'])
        || preg_match('/[^a-zA-Z\s]/', $attrs['last']) || preg_match('/[^a-zA-Z\s]/', $attrs['department'])){

            return redirect()->back()->with('error', 'Special Characters or Numbers is not allowed.');
        }

        if (Staff::where('id_number', $attrs['id'])->exists()) {
            return redirect()->back()->with('error', 'Staff ID already exists.');
        }

        Staff::create([
            'id_number' => $attrs['id'],
            'first' => $attrs['first'],
            'last' => $attrs['last'],
            'middle' => $attrs['middle'],
            'department' => $attrs['department'],
        ]);

        return redirect()->back()->with('success', 'Staff saved successfully.');
    }
    
    public function login(Request $request) {

        $attrs = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($attrs)) {
            $request->session()->regenerate();

            $user = Auth::user(); 
            session(['user_id' => $user->user_id]);

            $token = $user->createToken('authToken')->plainTextToken;

            // Get staff_entry grouped by date with counts
            $entries = DB::table('staff_entry')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(id) as count'))
                ->groupBy('date')
                ->orderByDesc('date')
                ->get();

            // Extract labels and data for chart
            $labels = $entries->pluck('date')->toArray();
            $data = $entries->pluck('count')->toArray();

            return view('attendance.dashboard', compact('labels', 'data'));
        }

        // Handle failed login (optional)
        return back()->withErrors(['email' => 'Invalid credentials']);
    }



    public function linechart(){

        try {
            $data = DB::table('staff_entry')
                ->select('Date', DB::raw('COUNT(id) as ID'))
                ->groupBy('Date')
                ->orderByDesc('Date')
                ->get();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected error occurred!'], 500);
        }
    }

    public function staff_list(){
        $staff_list = Staff::all()->where('soft_del', 0);

        return view('attendance.staffList', compact('staff_list'));
    }


    public function staff_logs(){
        $staff_list = Logs::all();

        return view('attendance.staffLogs', compact('staff_list'));
    }

    public function update(Request $request, $id)
    {
        // Validate input
        $validated = $request->validate([
            'id_number' => 'required|size:6|unique:staff,id_number,' . $id,
            'first' => 'required|regex:/^[a-zA-Z\s]+$/',
            'middle' => 'required|regex:/^[a-zA-Z\s]+$/',
            'last' => 'required|regex:/^[a-zA-Z\s]+$/',
            'department' => 'required|regex:/^[a-zA-Z\s]+$/',
        ], [
            'id_number.size' => 'The ID must be exactly 6 digits.',
            'first.regex' => 'Special Characters or Numbers are not allowed in First Name.',
            'middle.regex' => 'Special Characters or Numbers are not allowed in Middle Initial.',
            'last.regex' => 'Special Characters or Numbers are not allowed in Last Name.',
            'department.regex' => 'Special Characters or Numbers are not allowed in Department.',
        ]);

        try {
            $staff = Staff::findOrFail($id);

            // Update staff record with validated data
            $staff->update([
                'id_number' => $validated['id_number'],
                'first' => $validated['first'],
                'middle' => $validated['middle'],
                'last' => $validated['last'],
                'department' => $validated['department'],
            ]);

            return redirect()->back()->with('success', 'Staff updated successfully.');
        } catch (\Exception $e) {
            // Log error if needed
            //Log::error('Staff update failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to update staff. Please try again.');
        }
    }


    public function delete($id)
    {
        // Find the staff record by ID or throw a 404 error if not found
        $staff = Staff::findOrFail($id);

        // Update the 'soft_del' column to mark the record as deleted
        $staff->update(['soft_del' => 1]);

        return redirect()->back()->with('success', 'Data deleted successfully.');

    }

        public function logout(Request $request) {

        Auth::guard('web')->logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/');
    }   
}

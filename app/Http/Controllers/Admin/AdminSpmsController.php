<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpmsForm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminSpmsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SpmsForm::class, 'spm');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['year', 'type','semester']);
        return inertia('Admin/SPMS/Index', [
            'spms' => SpmsForm::with(['user'])->filter($filters)->paginate(20)->withQueryString(),
            'years' => DB::table('spms_forms')->selectRaw('year')->distinct()->pluck('year'),
            'users' => User::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return inertia('Admin/SPMS/Create', [
            'users' => User::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->files->get('forms')[0]['file']['0']);
        $files = $request->files->get('forms');
        
        if(count($request->input('forms'))){
            foreach($request->input('forms') as $key => $form){
                // dd($request->file('forms')[0]);
                // $path = $files[$key]['file'][0]->store('spms', 'public');
                // $filename = time() . '_' .$files[$key]['file'][0]->getClientOriginalName();
                // $path = Storage::disk('public')->put('spms/', $filename, file_get_contents( $files[$key]['file'][0]));
                $path = $request->file('forms')[$key]['file'][0]->store('spms', 'public');

                SpmsForm::create([
                    'user_id' => $form['user']['id'],
                    'type' => $form['type'],
                    'year' => $form['year'],
                    'semester' => $form['semester'],
                    'rating' => $form['rating'],
                    'filepath' => $path
                ]);


            }
            return back()->with('success', 'Form has been added successfully.');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(SpmsForm $spmsForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SpmsForm $spm)
    {
        return inertia('Admin/SPMS/Edit', [
            'spms' => $spm
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SpmsForm $spmsForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SpmsForm $spm)
    {
        Storage::disk('public')->delete($spm->filepath);
        $spm->delete();

        return back()->with('success', 'Form has been deleted.');
    }
}

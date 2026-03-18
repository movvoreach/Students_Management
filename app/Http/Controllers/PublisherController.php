<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublisherController extends Controller
{
    // LIST PAGE
    public function index()
    {
        return view('publishers.index');
    }

    // CREATE PAGE
    public function create()
    {
        return view('publishers.create');
    }

    // STORE (for future use)
    public function store(Request $request)
    {
        // later connect DB
        return redirect()->route('publishers.index');
    }

    // EDIT PAGE
    public function edit($id)
    {
        return view('publishers.edit');
    }

    // UPDATE (future)
    public function update(Request $request, $id)
    {
        return redirect()->route('publishers.index');
    }

    // DELETE (future)
    public function destroy($id)
    {
        return back();
    }
}

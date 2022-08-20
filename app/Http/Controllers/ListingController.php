<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class ListingController extends Controller
{
    // Show all listings
    public function index() {
        return view('listings', [
            // 'heading' => 'Latest Listings',
            'listings' => Listing::latest()
            ->filter(request(['tag', 'search']))->simplePaginate(6)
        ]);
    }

    // Show single listing
    public function show(Listing $listing) {
        return view('listing', [
            'listing' => $listing
        ]);
    }

    // Show Create Form
    public function create() {
        return view('create');
    }

    // Store Listing Data
    public function store(Request $request) {
        dd($request->file('logo'));
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        Listing::create($formFields);

        // Session::flash('message', 'Listing Created');

        return redirect('/')->with('message', 'Listing created 
        successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::with(['category', 'tags']);
        if ($keyword = $request->input('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->Where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if ($gender = $request->input('gender')) {
            $query->where('gender', $gender);
        }

        $category_id = $request->input('category_id');
        if ($request->filled('category_id')) {
            $query->where('category_id', $category_id);
        }

        $date = $request->input('date');
        if ($request->filled('date')) {
            $query->whereDate('created_at', $date);
        }

        $contacts = $query->paginate(7);

        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.index', [
            'contacts' => $contacts,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function show($contact)
    {
        $contact = Contact::with(['category', 'tags'])->findOrFail($contact);

        return view('admin.show', [
            'contact' => $contact,
        ]);
    }
}

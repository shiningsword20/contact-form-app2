<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexContactRequest;
use App\Http\Requests\Api\V1\StoreContactRequest;
use App\Http\Requests\Api\V1\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Support\Arr;

class ContactController extends Controller
{
    public function index(IndexContactRequest $request)
    {
        $query = Contact::with(['category', 'tags']);

        if($keyword = $request->input('keyword')) {
            $query->where(function ($q) use($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if($gender = $request->input('gender')) {
            $query->where('gender', $gender);
        }

        $category_id = $request->input('category_id');
        if($request->filled('category_id')) {
            $query->where('category_id', $category_id);
        }

        $date = $request->input('date');
        if($request->filled('date')) {
            $query->whereDate('created_at', $date);
        }

        $per_page = $request->input('per_page', 20);
        $contacts = $query->latest()->paginate($per_page);

        return ContactResource::collection($contacts);
    }

    public function show(Contact $contact)
    {
        $contact->load(['category', 'tags']);
        return ContactResource::make($contact);
    }

    public function store(StoreContactRequest $request)
    {
        $validated = $request->validated();
        $tagIds = Arr::pull($validated, 'tag_ids', []);
        $contact = Contact::create($validated);
        $contact->tags()->attach($tagIds);
        $contact->load(['category', 'tags']);

        return ContactResource::make($contact)->response()->setStatusCode(201);
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $validated = $request->validated();
        $tagIds = Arr::pull($validated, 'tag_ids', []);
        $contact->update($validated);
        $contact->tags()->sync($tagIds);
        $contact->load(['category', 'tags']);

        return ContactResource::make($contact);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json(null, 204);
    }
}

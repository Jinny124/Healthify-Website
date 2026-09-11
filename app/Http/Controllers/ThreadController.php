<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThreadController extends Controller
{
    public function create(Request $request)
    {

        return view('threads.thread.create');
    }

    public function destroy(Thread $thread)
    {
        if (auth()->id() !== $thread->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $thread->delete();

        return redirect()->route('threads.search')->with('message', 'Thread deleted successfully!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'threads_image' => ['nullable', 'file', 'mimes:jpeg,png,pdf', 'max:2048'],
        ]);

        $imageUrl = null;
        if ($request->hasFile('threads_image')) {
            // Use Azure when it is configured, otherwise fall back to the
            // local public disk so uploads work without cloud credentials.
            $disk = config('filesystems.disks.azure.key') ? 'azure' : 'public';

            $path = $request->file('threads_image')->store('threads', $disk);

            $imageUrl = $disk === 'azure'
                ? config('filesystems.disks.azure.url').'/'.$path
                : Storage::disk('public')->url($path);
        }

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'body' => $validated['body'],
            'threads_image' => $imageUrl,
        ]);

        return redirect()->route('threads.thread.show', $thread)
            ->with('success', 'Thread created successfully.');
    }

    public function show(Thread $thread)
    {
        $thread->load('user', 'comments.user', 'comments.childComments.user');

        return view('threads.thread.show', compact('thread'));
    }

    public function search(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $threads = null;

        if ($filter === 'popular') {
            $threads = Thread::withCount([
                'upvotes as upvote_count' => function ($query) {
                    $query->where('vote_type', 'upvote');
                },
                'upvotes as downvote_count' => function ($query) {
                    $query->where('vote_type', 'downvote');
                },
            ])
                ->orderByRaw('upvote_count - downvote_count DESC')
                ->paginate(5)
                ->appends(['filter' => $filter]);
        } elseif ($filter === 'search') {
            $searchTerm = $request->query('search', '');
            $threads = Thread::where('title', 'like', '%'.$searchTerm.'%')
                ->orWhere('body', 'like', '%'.$searchTerm.'%')
                ->paginate(5)
                ->appends(['filter' => $filter, 'search' => $searchTerm]);
        } else {
            $threads = Thread::with('user')
                ->latest()
                ->paginate(5)
                ->appends(['' => $filter]);
        }

        return view('threads.thread.index', compact('threads'));
    }
}

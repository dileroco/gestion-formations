<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFormationRequest;
use App\Http\Requests\Admin\UpdateFormationRequest;
use App\Models\Category;
use App\Models\Formation;
use App\Models\User;
use Illuminate\Support\Str;

class FormationController extends Controller
{
    public function index()
    {
        $query = Formation::query()->with('category');

        if (auth()->user()?->hasRole('Formateur')) {
            $query->where('user_id', auth()->id());
        }

        $formations = $query->latest()->paginate(10);

        return view('admin.formations.index', compact('formations'));
    }

    public function create()
    {
        $categories = Category::query()->orderBy('name_fr')->get();
        $trainers = User::role('Formateur')->orderBy('name')->get();

        return view('admin.formations.create', compact('categories', 'trainers'));
    }

    public function store(StoreFormationRequest $request)
    {
        $data = $request->validated();

        if (auth()->user()->hasRole('Formateur')) {
            $data['user_id'] = auth()->id();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('formations', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Formation::create($data);

        return redirect()
            ->route('admin.formations.index')
            ->with('status', 'Formation créée avec succès.');
    }

    public function show(Formation $formation)
    {
        $this->authorizeOwner($formation);
        return view('admin.formations.show', compact('formation'));
    }

    public function edit(Formation $formation)
    {
        $this->authorizeOwner($formation);
        $categories = Category::query()->orderBy('name_fr')->get();
        $trainers = User::role('Formateur')->orderBy('name')->get();

        return view('admin.formations.edit', compact('formation', 'categories', 'trainers'));
    }

    public function update(UpdateFormationRequest $request, Formation $formation)
    {
        $this->authorizeOwner($formation);
        $data = $request->validated();

        if (auth()->user()->hasRole('Formateur')) {
            unset($data['user_id']); // Cannot reassign creator if formateur
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('formations', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $formation->update($data);

        return redirect()
            ->route('admin.formations.index')
            ->with('status', 'Formation mise à jour.');
    }

    public function destroy(Formation $formation)
    {
        $this->authorizeOwner($formation);
        $formation->delete();

        return redirect()
            ->route('admin.formations.index')
            ->with('status', 'Formation supprimée.');
    }

    protected function authorizeOwner(Formation $formation)
    {
        if (auth()->user()->hasRole('Formateur') && $formation->user_id !== auth()->id()) {
            abort(403);
        }
    }
}

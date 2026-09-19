<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\DocumentsValidesMail;

class AdminDocumentController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'client')
            ->whereIn('statut_documents', ['en_attente', 'valide', 'refuse'])
            ->orderByRaw("CASE WHEN statut_documents = 'en_attente' THEN 0 ELSE 1 END")
            ->latest('updated_at')
            ->get();

        return view('admin.documents.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.documents.show', compact('user'));
    }

    public function viewFile(User $user, string $type)
    {
        $path = $type === 'identite'
            ? $user->piece_identite_fichier
            : $user->permis_fichier;

        if (!$path || !Storage::disk('private')->exists($path)) {
            abort(404, 'Fichier introuvable.');
        }

        return Storage::disk('private')->response($path);
    }

    public function approve(User $user)
    {
        $user->update([
            'statut_documents' => 'valide',
            'motif_refus' => null,
            'documents_valides_at' => now(),
        ]);

        Mail::to($user->email)->send(new DocumentsValidesMail($user));

        return redirect()
            ->route('admin.documents.index')
            ->with('success', "Les documents de {$user->name} ont été validés.");
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'motif_refus' => 'required|string|max:255',
        ]);

        $user->update([
            'statut_documents' => 'refuse',
            'motif_refus' => $request->motif_refus,
            'documents_valides_at' => null,
        ]);

        return redirect()
            ->route('admin.documents.index')
            ->with('success', "Les documents de {$user->name} ont été refusés.");
    }
}
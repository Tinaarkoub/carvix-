<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser as PdfParser;

class DocumentController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return view('documents.show', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_piece_identite' => 'required|in:cni,passeport',
            'piece_identite_fichier' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240', $this->pdfPageLimit()],
            'permis_fichier' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240', $this->pdfPageLimit()],
        ], [
            'piece_identite_fichier.required' => 'Merci d\'ajouter une photo ou un scan de votre pièce d\'identité.',
            'permis_fichier.required' => 'Merci d\'ajouter une photo ou un scan de votre permis de conduire.',
            'piece_identite_fichier.mimes' => 'Le fichier doit être une image (jpg, png) ou un PDF.',
            'permis_fichier.mimes' => 'Le fichier doit être une image (jpg, png) ou un PDF.',
            'piece_identite_fichier.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
            'permis_fichier.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
        ]);

        $user = Auth::user();

        if ($user->piece_identite_fichier) {
            Storage::disk('private')->delete($user->piece_identite_fichier);
        }
        if ($user->permis_fichier) {
            Storage::disk('private')->delete($user->permis_fichier);
        }

        $pieceIdentitePath = $request->file('piece_identite_fichier')
            ->store('documents/identite', 'private');

        $permisPath = $request->file('permis_fichier')
            ->store('documents/permis', 'private');

        $user->update([
            'type_piece_identite' => $request->type_piece_identite,
            'piece_identite_fichier' => $pieceIdentitePath,
            'permis_fichier' => $permisPath,
            'statut_documents' => 'en_attente',
            'motif_refus' => null,
            'documents_valides_at' => null,
        ]);

        return redirect()
            ->route('documents.show')
            ->with('success', 'Vos documents ont été envoyés. Un administrateur va les vérifier sous peu.');
    }

    /**
     * Règle de validation personnalisée : si le fichier est un PDF,
     * il ne doit pas dépasser 2 pages.
     */
    private function pdfPageLimit()
    {
        return function ($attribute, $value, $fail) {
            if (!$value || $value->getClientOriginalExtension() !== 'pdf') {
                return;
            }

            try {
                $parser = new PdfParser();
                $pdf = $parser->parseFile($value->getRealPath());
                $pageCount = count($pdf->getPages());

                if ($pageCount > 2) {
                    $fail("Le PDF ne doit pas dépasser 2 pages (actuellement {$pageCount} pages).");
                }
            } catch (\Exception $e) {
                $fail('Impossible de lire ce fichier PDF. Merci de vérifier qu\'il n\'est pas corrompu.');
            }
        };
    }
}
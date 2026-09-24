<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return view('admin.utilisateurs', compact('users'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'role' => [
                'required',
                'in:admin,livreur',
            ],
        ]);


        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],

            // Mot de passe aléatoire
            'password' => Hash::make(Str::random(40)),

            'role' => $validated['role'],
        ]);


        $status = Password::sendResetLink([
            'email' => $user->email,
        ]);


        if ($status !== Password::RESET_LINK_SENT) {
            return redirect()
                ->back()
                ->withErrors([
                    'email' =>
                        'Le compte a été créé, mais l’email pour définir le mot de passe n’a pas pu être envoyé.',
                ]);
        }


        return redirect()
            ->back()
            ->with(
                'success',
                'Utilisateur créé avec succès. Un email a été envoyé à '
                . $user->email
                . ' pour choisir son mot de passe.'
            );
    }


    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'role' => [
                'required',
                'in:admin,livreur',
            ],
        ]);


        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        $user->save();


        return redirect()
            ->back()
            ->with(
                'success',
                'Utilisateur modifié avec succès.'
            );
    }


    /**
     * Modifier le mot de passe de l'utilisateur connecté — interface web (Blade).
     *
     * Réservé au formulaire web : réponse par redirection + message flash en
     * session, authentification par session (Auth::attempt / guard web).
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate(
            [
                'current_password' => [
                    'required',
                    'current_password',
                ],

                'new_password' => [
                    'required',
                    'string',
                    'confirmed',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[^A-Za-z0-9]/',
                ],
            ],
            [
                'current_password.required' =>
                    'Veuillez saisir votre mot de passe actuel.',

                'current_password.current_password' =>
                    'Votre mot de passe actuel est incorrect.',

                'new_password.required' =>
                    'Veuillez saisir un nouveau mot de passe.',

                'new_password.confirmed' =>
                    'La confirmation du nouveau mot de passe ne correspond pas.',

                'new_password.min' =>
                    'Le nouveau mot de passe doit contenir au moins 8 caractères.',

                'new_password.regex' =>
                    'Le nouveau mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
            ]
        );


        $request->user()->update([
            'password' => Hash::make($validated['new_password']),
        ]);


        return back()->with(
            'password_success',
            'Votre mot de passe a été modifié avec succès.'
        );
    }

    /**
     * Modifier le mot de passe de l'utilisateur connecté — API (Flutter).
     *
     * Mêmes règles de validation que updatePassword(), mais réponse JSON et
     * authentification par token Sanctum (route à protéger par
     * le middleware auth:sanctum).
     */
    public function updatePasswordApi(Request $request)
    {
        $validated = $request->validate(
            [
                'current_password' => [
                    'required',
                    'current_password',
                ],

                'new_password' => [
                    'required',
                    'string',
                    'confirmed',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[^A-Za-z0-9]/',
                ],
            ],
            [
                'current_password.required' =>
                    'Veuillez saisir votre mot de passe actuel.',

                'current_password.current_password' =>
                    'Votre mot de passe actuel est incorrect.',

                'new_password.required' =>
                    'Veuillez saisir un nouveau mot de passe.',

                'new_password.confirmed' =>
                    'La confirmation du nouveau mot de passe ne correspond pas.',

                'new_password.min' =>
                    'Le nouveau mot de passe doit contenir au moins 8 caractères.',

                'new_password.regex' =>
                    'Le nouveau mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
            ]
        );


        $request->user()->update([
            'password' => Hash::make($validated['new_password']),
        ]);


        return response()->json([
            'message' => 'Votre mot de passe a été modifié avec succès.',
        ]);
    }


    /**
     * Liste des livreurs — API (Flutter), pour l'écran admin "Livreurs".
     *
     * Renvoie tous les comptes livreurs, avec un indicateur de
     * disponibilité (aucune livraison "En préparation" ou "En cours").
     */
    public function livreurs()
    {
        $livreurs = User::where('role', 'livreur')
            ->withCount([
                'livraisons as livraisons_en_cours_count' => function ($query) {
                    $query->whereIn('statut', [
                        'En préparation',
                        'En cours',
                    ]);
                },
            ])
            ->get()
            ->map(function ($livreur) {
                return [
                    'id' => $livreur->id,
                    'name' => $livreur->name,
                    'email' => $livreur->email,
                    'disponible' => $livreur->livraisons_en_cours_count === 0,
                ];
            });

        return response()->json($livreurs);
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->back()
            ->with(
                'success',
                'Utilisateur supprimé avec succès.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Méthodes API (Flutter) — réponses JSON, pour l'écran admin "Utilisateurs"
    |--------------------------------------------------------------------------
    */

    /**
     * Liste de tous les utilisateurs (admin + livreurs) — API.
     */
    public function indexApi()
    {
        $users = User::latest()->get(['id', 'name', 'email', 'role']);

        return response()->json($users);
    }

    /**
     * Créer un utilisateur — API.
     *
     * Même logique que store() : mot de passe aléatoire + email pour
     * que l'utilisateur définisse son propre mot de passe.
     */
    public function storeApi(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'role' => [
                'required',
                'in:admin,livreur',
            ],
        ]);


        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make(Str::random(40)),
            'role' => $validated['role'],
        ]);


        $status = Password::sendResetLink([
            'email' => $user->email,
        ]);


        if ($status !== Password::RESET_LINK_SENT) {
            return response()->json([
                'message' =>
                    'Le compte a été créé, mais l’email pour définir le mot de passe n’a pas pu être envoyé.',
                'user' => $user,
            ], 201);
        }


        return response()->json([
            'message' =>
                'Utilisateur créé avec succès. Un email a été envoyé à '
                . $user->email
                . ' pour choisir son mot de passe.',
            'user' => $user,
        ], 201);
    }

    /**
     * Modifier un utilisateur — API.
     */
    public function updateApi(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'role' => [
                'required',
                'in:admin,livreur',
            ],
        ]);


        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        $user->save();


        return response()->json([
            'message' => 'Utilisateur modifié avec succès.',
            'user' => $user,
        ]);
    }

    /**
     * Supprimer un utilisateur — API.
     */
    public function destroyApi(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'Utilisateur supprimé avec succès.',
        ]);
    }
}
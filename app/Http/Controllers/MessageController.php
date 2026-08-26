<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use App\Mail\NouveauMessageLivreur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class MessageController extends Controller
{
    public function create()
    {
        return view('livreur.messages.create');
    }

    public function store(Request $request)
    {
        
        $admin = User::where('role', 'admin')->first();

$request->validate([
    'sujet' => 'required|string|max:255',
    'contenu' => 'required|string',
]);

        if (!$admin) {
            return back()->withErrors([
                'admin' => 'Aucun administrateur trouvé.'
            ]);
        }

        $message = Message::create([
    'expediteur_id' => auth()->id(),
    'destinataire_id' => $admin->id,
    'sujet' => $request->sujet,
    'contenu' => $request->contenu,
    'lu' => false,
]);

        Notification::create([
            'user_id' => $admin->id,
            'titre' => 'Nouveau message',
            'contenu' => auth()->user()->name . ' vous a envoyé un message : ' . $message->sujet,
            'type' => 'message',
            'lu' => false,
        ]);

        Mail::to($admin->email)->send(
    new NouveauMessageLivreur($message)
); 

        return back()->with(
            'success',
            'Votre message a bien été envoyé.'
        );
    }
public function index()
{
    $messages = Message::with(['expediteur', 'livraison'])
        ->where('destinataire_id', auth()->id())
        ->latest()
        ->get();

    return view('admin.messages.index', compact('messages'));
}
        public function show(Message $message)
    {
        abort_if(
            $message->destinataire_id !== auth()->id(),
            403
        );

        $message->update([
            'lu' => true
        ]);

        Notification::where('user_id', auth()->id())
            ->where('type', 'message')
            ->where('contenu', 'like', '%' . $message->sujet . '%')
            ->update([
                'lu' => true
            ]);

        $message->load(['expediteur', 'livraison']);

        return view('admin.messages.show', compact('message'));
    }
}
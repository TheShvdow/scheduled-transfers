<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessScheduledTransfer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TransferController extends Controller
{
    public function scheduleTransfer(Request $request)
    {
        // Valider la requête
        $validated = $request->validate([
            'id' => 'required|string',
            'transactionId' => 'required|string',
            'senderUid' => 'required|string',
            'recipientPhone' => 'required|string',
            'amount' => 'required|numeric',
            'frequency' => 'required|string',
            'scheduledTime' => 'required|date',
        ]);

        // Envoyer les données au job pour traitement
        ProcessScheduledTransfer::dispatch(
            $validated['id'],
            $validated['transactionId'],
            $validated['senderUid'],
            $validated['recipientPhone'],
            $validated['amount'],
            $validated['frequency'],
            $validated['scheduledTime']
        );

        return response()->json(['message' => 'Transfert programmé avec succès !']);
    }
}
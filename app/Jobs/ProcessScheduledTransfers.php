<?php

namespace App\Jobs;

use Kreait\Firebase\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ProcessScheduledTransfers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $transactionId;
    protected $senderUid;
    protected $recipientPhone;
    protected $amount;
    protected $frequency;
    protected $scheduledTime;

    /**
     * Créer une nouvelle instance de job.
     *
     * @param string $id
     * @param string $transactionId
     * @param string $senderUid
     * @param string $recipientPhone
     * @param float $amount
     * @param string $frequency
     * @param string $scheduledTime
     */
    public function __construct($id, $transactionId, $senderUid, $recipientPhone, $amount, $frequency, $scheduledTime)
    {
        $this->id = $id;
        $this->transactionId = $transactionId;
        $this->senderUid = $senderUid;
        $this->recipientPhone = $recipientPhone;
        $this->amount = $amount;
        $this->frequency = $frequency;
        $this->scheduledTime = $scheduledTime;
    }

    /**
     * Exécuter le job.
     *
     * @return void
     */
    public function handle()
    {
        // Créer un transfert dans Firestore
        $firebase = (new Factory)
            ->withServiceAccount(env('FIREBASE_CREDENTIALS'))
            ->createFirestore();

        $firestore = $firebase->database();

        // Ajouter les données du transfert programmé dans la collection "scheduled_transfers"
        $firestore->collection('scheduled_transfers')->add([
            'id' => $this->id,
            'transactionId' => $this->transactionId,
            'senderUid' => $this->senderUid,
            'recipientPhone' => $this->recipientPhone,
            'amount' => $this->amount,
            'frequency' => $this->frequency,
            'scheduledTime' => $this->scheduledTime,
            'status' => 'scheduled',
        ]);

        Log::info('Transfert programmé enregistré dans Firestore :', [
            'id' => $this->id,
            'transactionId' => $this->transactionId,
            'senderUid' => $this->senderUid,
            'recipientPhone' => $this->recipientPhone,
            'amount' => $this->amount,
            'frequency' => $this->frequency,
            'scheduledTime' => $this->scheduledTime,
        ]);
    }
}
<?php

namespace App\Listeners;

use App\Events\ReceiptSaved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReceipt implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ReceiptSaved  $event
     * @return void
     */
    public function handle(ReceiptSaved $event)
    {
        $receipt = $event->receipt;
        $receipt_event = $receipt->event;
        $numberInGroups = $receipt_event->numberInGroups;
        $numberInGroups = json_decode($numberInGroups);
        $priceForGroup = $receipt_event->priceForGroup;
        $priceForGroup = json_decode($priceForGroup); 
        if($receipt->group_id == NULL){
            $receipt->toBePaid = $receipt_event->pricePerPerson - $receipt->amount;
            $data =     array(  'name'=>$receipt->name,
                                'email'=>$receipt->email,
                                'pathToFile' => public_path().'/images/aefasdgadrt53#$%34ewfaesdgflagfsjsrasdQRCODE/'.$receipt->id.'.png',
                                'amount' => $receipt->amount,
                                'toBePaid' => $receipt->toBePaid);
            $contactEmail = $receipt->email;
            $contactName = $receipt->name;
            //dd($data);
            \Mail::send ( 'emails.test2', $data, function ($message) use ($contactEmail, $contactName)
            {
        
                $message->from ( 'hello@ecellskncoe.in', 'E-Cell Team' );
                
                $message->to ($contactEmail);

                $message->cc ('hello@ecellskncoe.in');

                $message->subject ( 'Ecell - Econclave 2K17 Receipt' );
            });
        }
        else{
            $numberOfMembersInGroup = $receipt->group->numberOfReceipts;
            $key = array_search($numberOfMembersInGroup, $numberInGroups);
            $amountToBePaid = $priceForGroup[$key];
            $receipt->toBePaid = $amountToBePaid - $receipt->amount;
            $data =     array(  'name'=>$receipt->name,
                                'email'=>$receipt->email,
                                'pathToFile' => public_path().'/images/aefasdgadrt53#$%34ewfaesdgflagfsjsrasdQRCODE/'.$receipt->id.'.png',
                                'amount' => $receipt->amount,
                                'toBePaid' => $receipt->toBePaid,
                                'numberInGroup' => $numberOfMembersInGroup);
            $contactEmail = $receipt->email;
            $contactName = $receipt->name;
            //dd($data);
            \Mail::send ( 'emails.test2', $data, function ($message) use ($contactEmail, $contactName)
            {
        
                $message->from ( 'hello@ecellskncoe.in', 'E-Cell Team' );
                
                $message->to ($contactEmail);

                $message->cc ('hello@ecellskncoe.in');

                $message->subject ( 'Ecell - Econclave 2K17 Receipt' );
            });
        }
    }
}

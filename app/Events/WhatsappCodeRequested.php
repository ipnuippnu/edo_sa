<?php

namespace App\Events;

use App\Models\ContactVerificationCode;
use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class WhatsappCodeRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected int $codeId;

    /**
     * Create a new event instance.
     */
    public function __construct(public string $phoneNumber)
    {
        ContactVerificationCode::whereContact($phoneNumber)->delete();

        do {
            $code = rand(11111, 99999);
        } while (ContactVerificationCode::whereCode($code)->exists());

        $code = ContactVerificationCode::create([
            'type' => 'whatsapp',
            'code' => $code,
            'contact' => $this->phoneNumber,
            'valid_until' => Carbon::now()->addHours(6)->addMinute()
        ]);

        $this->codeId = $code->id;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}

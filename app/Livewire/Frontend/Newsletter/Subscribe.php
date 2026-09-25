<?php

namespace App\Livewire\Frontend\Newsletter;

use App\Models\NewsletterSubscriber;
use Livewire\Component;

class Subscribe extends Component
{
    public $email = '';

    protected $rules = [
        'email' => 'required|email|max:255',
    ];

    protected $messages = [
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
    ];

    public function subscribe()
    {
        $this->validate();

        // Simpan sebagai subscriber aktif. Bila email pernah berhenti berlangganan,
        // aktifkan kembali alih-alih membuat duplikat (email bersifat unique).
        NewsletterSubscriber::updateOrCreate(
            ['email' => $this->email],
            ['subscribed_at' => now(), 'unsubscribed_at' => null],
        );

        session()->flash('success', 'Terima kasih! Anda telah berlangganan newsletter kami.');

        // Reset form
        $this->reset('email');
    }

    public function render()
    {
        return view('livewire.frontend.newsletter.subscribe');
    }
}

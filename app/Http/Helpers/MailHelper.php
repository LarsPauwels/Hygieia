<?php
namespace App\Http\Helpers;

use Illuminate\Support\Facades\Mail;
use App\Mail\Mail as SendMail;

class MailHelper {

    public static function newAccount($client, $password) {
        $data = [
            'title' => 'Nieuw Account',
            'subtitle' => 'Er is een nieuw account aangemaakt voor u!',
            'name' => $client->name,
            'text' => 'Er is een nieuw account voor u aangemaakt. Gebruik bovenstaande knop om uw wachtwoord te wijzigen. Dank u voor het vertrouwen in Hygieia.',
            'url' => config('app.url').'?token='.$password
        ];
        Mail::to($client->email)->queue(new SendMail($data));
    }

    public static function accountExpired($client, $days) {
        $data = [
            'title' => 'Account Verlopen',
            'subtitle' => 'Dit account verloopt binnen enkele dagen!',
            'name' => $client->name,
            'text' => 'Het account van de gebruiker "'.$client->name.'" verloopt binnen '.$days.' dagen.',
            'url' => config('app.url')
        ];
        Mail::to($client->email)->queue(new SendMail($data));
    }

    public static function accountRemove($client) {
        $data = [
            'title' => 'Account Verlopen',
            'subtitle' => 'Dit account is verlopen!',
            'name' => $client->name,
            'text' => 'Het account van de gebruiker "'.$client->name.'" is verlopen en zal sinds vandaag niet meer gebruikt kunnen worden.',
            'url' => config('app.url')
        ];
        Mail::to($client->email)->queue(new SendMail($data));
    }

    public static function forgotPassword($client, $password) {
        $data = [
            'title' => 'Wachtwoord vergeten',
            'subtitle' => 'Hier kan je je wachtwoord opnieuw instllen!',
            'name' => $client->name,
            'text' => 'Klik hierboven op de knop om je wachtwoord opnieuw in te stellen.',
            'url' => config('app.url').'?token='.$password
        ];
        Mail::to($client->email)->queue(new SendMail($data));
    }
}
<?php

namespace App\Mail;

use App\Models\User;

trait SendGrid
{
    public function addTracking($category, User $user)
    {
        $headerData = [
            'category' => $category,
            'unique_args' => [
                'user_ref' => md5($user->id . now()->timestamp)
            ]
        ];

        $header = $this->asString($headerData);

        $this->withSwiftMessage(function ($message) use ($header) {
            $message->getHeaders()
                ->addTextHeader('X-SMTPAPI', $header);
        });
    }

    private function asJSON($data)
    {
        $json = json_encode($data);
        $json = preg_replace('/(["\]}])([,:])(["\[{])/', '$1$2 $3', $json);

        return $json;
    }

    private function asString($data)
    {
        $json = $this->asJSON($data);

        return wordwrap($json, 76, "\n   ");
    }
}
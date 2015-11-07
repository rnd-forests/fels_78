<?php

namespace FELS\Core\Mailer;

use Illuminate\Mail\Mailer;

abstract class AbstractMailer
{
    /**
     * A generic method to send emails throughout application.
     *
     * @param $user
     * @param $subject
     * @param $view
     * @param array $data
     * @return mixed
     */
    public function sendTo($user, $subject, $view, $data = [])
    {
        $mailer = app(Mailer::class);
        $mailer->queue($view, $data, function ($message) use ($user, $subject) {
            $message->to($user->email)->subject($subject);
        });
    }
}

<?php

namespace app\mail;

use easy\mail\EmailBody;
use easy\mail\Mailer;

class FeedbackMail extends Mailer
{
    /**
     * @return void
     */
    public function sendEmail()
    {
        $this->createEmail()
            ->addTo('after@ya.ru')
            ->setSubject('test')
            ->setBody(new EmailBody('test'))
            ->send();
    }
}
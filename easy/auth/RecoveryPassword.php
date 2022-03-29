<?php

namespace easy\auth;

use easy\mail\Email;
use easy\mail\EmailBody;

class RecoveryPassword
{
    public string $url = 'http://easy-one/reset?code=';
    public string $recoveryCode;
    public string $email;

    /**
     * @return void
     */
    public function makeRecoveryCode(): void
    {
        $this->recoveryCode = md5($this->url . time() . $this->email . rand(0, 100));
    }

    /**
     * @return bool
     */
    public function sendRecoveryMail(): bool
    {
        return (new Email())
            ->addTo($this->email)
            ->setFrom('max@kuba.msk.ru', 'easy-one')
            ->setSubject('Recovery password')
            ->setBody(new EmailBody("Link to recovery password: $this->url$this->recoveryCode"))
            ->send();
    }
}

<?php

namespace app\controllers;

use app\entities\Feedback;
use app\entities\FeedbackStatus;
use app\mail\FeedbackMail;
use app\storages\FeedbackStorage;
use easy\basic\router\Route;
use easy\db\Transaction;
use easy\http\Request;
use easy\mail\Mailer;
use easy\MVC\Controller;

#[Route('/feedback')]
class FeedbackController extends Controller
{
    /**
     * @throws \Throwable
     */
    #[Route('/new', name: 'new_feedback')]
    public function new(FeedbackStorage $storage, Transaction $transaction, Request $request)
    {
        $errorMessage = '';
        try {
            if ($request->isPost()) {
                $transaction->begin();
                $feedback = new Feedback();
                $feedback->from = $request->query('from');
                $feedback->email = $request->query('email');
                $feedback->question = $request->query('question');
                if (!$feedback->from || !$feedback->email || !$feedback->question) {
                    throw new \Exception('All fields are required');
                }
                $feedback->question_date = new \DateTime();
                $feedback->status = FeedbackStatus::NEW;
                $id = $storage->store($feedback);
                $transaction->commit();
                $this->redirectToRoute('feedback_sent', ['id' => $id]);
            }
        } catch (\Exception $exception) {
            $transaction->rollback();
            $errorMessage = $exception->getMessage();
        }

        $this->render('feedback/new', [
            'errorMessage' => $errorMessage,
        ]);
    }

    #[Route('/complete', name: 'feedback_sent')]
    public function sent(Request $request, FeedbackMail $mail)
    {
        $mail->sendEmail();

        $this->render('feedback/sent', [
            'id' => $request->query('id'),
        ]);
    }
}

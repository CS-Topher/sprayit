<?php

require __DIR__ . '/../../vendor/autoload.php';

/**
 * SendGridTranslator class: This class talks to the mailing API to send emails from the program.
 */
class SendGridTranslator {

    /**
     * Send method: This is used to send an email message to a specified user.
     *
     * @author Chris T.
     */
    public static function send($_to = '', $_toName = '', $_subject = '', $_text = '', $_html = '') {
        try {
            $email = new \SendGrid\Mail\Mail();
            $email->setFrom(NOREPLY_ADDRESS, NOREPLY_NAME);
            $email->setSubject($_subject);
            $email->addTo($_to, $_toName);
            $email->addContent("text/plain", $_text);
            //$email->addContent("text/html", $_html);
            $sendgrid = new \SendGrid(SENDGRID_KEY);
        } catch (Exception $e) {
            die('Problem creating email');
        }
        try {
            $response = $sendgrid->send($email);
//            print $response->statusCode() . "\n";
//            print_r($response->headers());
//            print $response->body() . "\n";
            return true;
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
            return false;
        }
    }
}
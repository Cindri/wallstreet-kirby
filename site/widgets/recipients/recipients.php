<?php

require_once (__DIR__ . DS . '../../controllers/Newsletter/Services/RecipientsService.php');

$recipientService = new RecipientsService();
$recipientList = $recipientService->getRecipients();

return array(
    'title' => 'Newsletter Empfängerliste',
    'html' => function() use ($recipientList) {
        return tpl::load(__DIR__ . DS . 'recipients.html.php', [
            'recipients' => $recipientList
        ]);
    }
);
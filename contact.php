<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = $_POST['user_name'];
    $email = $_POST['user_mail'];
    $message = $_POST['user_message'];

    // Adresse e-mail de réception
    $to = "";

    // Sujet de l'e-mail
    $subject = "Nouveau message de contact de $name du site Avoine Tom";

    // Contenu de l'e-mail
    $email_content = "Nom: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // En-têtes de l'e-mail
    $headers = "From: $name <$email>";

    // Configuration SMTP pour Gmail
    $smtp_username = '';
    $smtp_password = '';
    $smtp_host = 'smtp.gmail.com';
    $smtp_port = 587;
    $smtp_secure = 'tls';

    // Configuration des paramètres SMTP
    ini_set('SMTP', $smtp_host);
    ini_set('smtp_port', $smtp_port);
    ini_set('sendmail_from', $smtp_username);

    // Configuration des paramètres de transport SMTP
    $transport = (new Swift_SmtpTransport($smtp_host, $smtp_port, $smtp_secure))
        ->setUsername($smtp_username)
        ->setPassword($smtp_password);

    // Création de l'objet Mailer
    $mailer = new Swift_Mailer($transport);

    // Création de l'e-mail
    $message = (new Swift_Message($subject))
        ->setFrom([$email => $name])
        ->setTo($to)
        ->setBody($email_content);

    // Envoyer l'e-mail
    if ($mailer->send($message)) {
        echo "Votre message a été envoyé avec succès.";
    } else {
        echo "Une erreur s'est produite lors de l'envoi du message.";
    }
} else {
    echo "Une erreur s'est produite lors de l'envoi du formulaire.";
}
?>

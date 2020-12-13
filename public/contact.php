<?php

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

require __DIR__.'/vendor/autoload.php';

$loader = new FilesystemLoader(__DIR__.'/templates');

$twig = new Environment($loader, [

'debug' => true,
'strict_variables' => true,
]);

$twig->addExtension(new DebugExtension());


echo $twig->render('contact.html.twig', [
    'errors' => $errors,
]);

$twig->addExtension(new DebugExtension());

$formData = [
    'email' => '',
    'subject' => '',
    'message' => '',
];
$errors = [];

if ($_POST) {
    foreach ($formData as $key => $value) {
        if (isset($_POST[$key])) {
            $formData[$key] = $_POST[$key];
        }
    }

    $minLength = 3;
    $maxLength = 190;
    $maxLenghtArea = 1000;

    if (empty($_POST['email'])) {
        $errors['email'] = 'veuillez renseigner ce champ';
    } elseif (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
        $errors['email'] = 'veuillez renseigner un email valide';
    } elseif (strlen($_POST['email']) < 3 || strlen($_POST['email']) > 190) {
        $errors['email'] = "veuillez renseigner un email dont la longueur est comprise entre {$minLength} et {$maxLength} inclus";
    }



    if (empty($_POST['subject'])) {
        $errors['subject'] = 'veuillez renseigner ce champ';
    } elseif (strlen($_POST['subject']) < 3 || strlen($_POST['email']) > 190) {
        $errors['subject'] = "veuillez renseigner un sujet dont la longueur est comprise entre {$minLength} et {$maxLength} inclus";
    }

    if (empty($_POST['message'])) {
        $errors['message'] = 'veuillez renseigner ce champ';
    } elseif (strlen($_POST['message']) < 3 || strlen($_POST['email']) > 1000) {
        $errors['message'] = "veuillez renseigner un message dont la longueur est comprise entre {$minLength} et {$maxLengthArea} inclus";
    }

    if (!$errors) {
        $url = '/';
        header("Location : ${url}", true, 302);
        exit();
     }

}

echo $twig->render('contact.html.twig', [
    'errors' => $errors,
    'formData' => $formData,
]);


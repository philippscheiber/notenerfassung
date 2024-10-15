<?php

$errors = []; // Array zum Speichern der Fehlermeldungen

// Hauptvalidierungsfunktion
function validate($name, $email, $examDate, $grade, $subject) {
    return validateName($name) & validateEmail($email) & validateExamDate($examDate) & validateGrade($grade) & validateSubject($subject);
}

// Validierung des Namens
function validateName($name) {
    global $errors; // Zugriff auf das globale Fehler-Array
    if (empty($name)) {
        $errors['name'] = "Name darf nicht leer sein.";
        return false;
    } elseif (strlen($name) > 20) {
        $errors['name'] = "Name darf nicht länger als 20 Zeichen sein.";
        return false;
    }
    return true;
}

// Validierung der E-Mail-Adresse
function validateEmail($email) {
    global $errors; // Zugriff auf das globale Fehler-Array
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "E-Mail ungültig.";
        return false;
    }
    return true;
}

// Validierung des Prüfungsdatums
function validateExamDate($examDate) {
    global $errors; // Zugriff auf das globale Fehler-Array
    try {
        if (empty($examDate)) {
            $errors['examDate'] = "Datum darf nicht leer sein.";
            return false;
        } elseif (new DateTime($examDate) > new DateTime()) {
            $errors['examDate'] = "Prüfungsdatum darf nicht in der Zukunft liegen.";
            return false;
        }
        return true;
    } catch (Exception $e) {
        $errors['examDate'] = "Prüfungsdatum ungültig.";
        return false;
    }
}

// Validierung der Note
function validateGrade($grade) {
    global $errors; // Zugriff auf das globale Fehler-Array
    if (!is_numeric($grade) || $grade < 1 || $grade > 5) {
        $errors['grade'] = "Note ungültig. Die Note muss zwischen 1 und 5 liegen.";
        return false;
    }
    return true;
}

// Validierung des Fachs
function validateSubject($subject) {
    global $errors; // Zugriff auf das globale Fehler-Array
    $validSubjects = ['m', 'd', 'e']; // Liste der gültigen Fächer
    if (!in_array($subject, $validSubjects)) {
        $errors['subject'] = "Fach ungültig. Wählen Sie ein gültiges Fach.";
        return false;
    }
    return true;
}

?>

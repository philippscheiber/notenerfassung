<?php

class GradeEntry
{
    private $name = '';
    private $email = '';
    private $examDate = '';
    private $subject = '';
    private $grade = '';

    private $errors = [];

    /**
     * @param string $name
     * @param string $email
     * @param string $examDate
     * @param string $subject
     * @param string $grade
     * @param array $errors
     */
    public function __construct($name, $email, $examDate, $subject, $grade, array $errors)
    {
        $this->name = $name;
        $this->email = $email;
        $this->examDate = $examDate;
        $this->subject = $subject;
        $this->grade = $grade;
        $this->errors = $errors;
    }


    public static function getAll(){
        $grades = [];
        if(isset($_SESSION['grades'])){
            foreach($_SESSION['grades'] as $grade){
                $grades[]= unserialize($grade);
            }
        }
        return $grades;
    }

    public static function deleteAll(){
     if(isset($_SESSION['grades'])){
         unset($_SESSION['grades']);
     }
    }

    public function save(){
        if ($this->validate()){
            //speichern
            $s= serialize($this);
            $_SESSION['grades'][]= $s;
            return true;
        }
        return false;
    }

    public function validateName() {
        if (empty($this->name)) {
            $this->errors['name'] = "Name darf nicht leer sein.";
            return false;
        } elseif (strlen($this->name) > 20) {
            $this->errors['name'] = "Name darf nicht länger als 20 Zeichen sein.";
            return false;
        }
        return true;
    }

// Validierung der E-Mail-Adresse
   private function validateEmail() {
        if (!empty($this->email) && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "E-Mail ungültig.";
            return false;
        }
        return true;
    }

// Validierung des Prüfungsdatums
    private function validateExamDate() {
        try {
            if (empty($this->examDate)) {
                $this->errors['examDate'] = "Datum darf nicht leer sein.";
                return false;
            } elseif (new DateTime($this->examDate) > new DateTime()) {
                $this->errors['examDate'] = "Prüfungsdatum darf nicht in der Zukunft liegen.";
                return false;
            }
            return true;
        } catch (Exception $e) {
            $this->errors['examDate'] = "Prüfungsdatum ungültig.";
            return false;
        }
    }

// Validierung der Note
    private function validateGrade() {
        if (!is_numeric($this->grade) || $this->grade < 1 || $this->grade > 5) {
            $this->errors['grade'] = "Note ungültig. Die Note muss zwischen 1 und 5 liegen.";
            return false;
        }
        return true;
    }

// Validierung des Fachs
    function validateSubject() {
        $validSubjects = ['m', 'd', 'e']; // Liste der gültigen Fächer
        if (!in_array($this->subject, $this->validSubjects)) {
            $this->errors['subject'] = "Fach ungültig. Wählen Sie ein gültiges Fach.";
            return false;
        }
        return true;
    }



    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getExamDate()
    {
        return $this->examDate;
    }

    /**
     * @param string $examDate
     */
    public function setExamDate($examDate)
    {
        $this->examDate = $examDate;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param string $grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function hasErrors($field){
        return isset($this->errors[$field]);
    }

    /**
     * @param array $this->errors
     */



    public function getExamDateFormatted(){
        return date_format(date_create($this->examDate), 'd-m-Y');
    }

    public function getSubjectFormatted(){
        switch ($this->subject) {
            case 'm': return "Mathematik";
            case 'd': return "Deutsch";
            case 'e': return "Englisch";
            default: return null;
        }
    }


}


?>

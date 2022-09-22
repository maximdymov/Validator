<?php

class Validator
{
    private ?array $post = null;
    private array $errors = [];
    private array $postKeys = [
        'name', 'email', 'password'
    ];

    public function __construct()
    {
        if (!empty($_POST)) {
            $this->post = $_POST;
        } else {
            throw new Exception("POST is empty!");
        }

        if ($this->checkPost() == false) {
            throw new Exception("POST has incorrect fields");
        }
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function validate()
    {
        $this->check('email', $this->post['email']);
        $this->check('notEmpty', $this->post['name'], 'name');
        $this->check('notEmpty', $this->post['password'], 'password');
    }

    private function check($funcName, ...$field)
    {
        call_user_func_array(array($this, "$funcName"), $field);
    }

    private function email($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false)
            $this->addError('email', "Email is not valid!");
    }

    private function notEmpty($field, $fieldName)
    {
        if (empty($field))
            $this->addError("$fieldName", "Field must not be empty!");
    }

    private function checkPost(): bool
    {
        foreach ($this->postKeys as $key) {
            if (!array_key_exists($key, $this->post)) return false;
        }
        return true;
    }

    private function addError($field, $message)
    {
        $this->errors[$field] = $message;
    }
}



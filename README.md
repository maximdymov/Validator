# Validator

This is modifying validation component, working with POST array.

##How to use
Firstly, make sure that your $_POST and $postKeys
have the same fields.

 ```php
$_POST['email'] = '123@example.com';
$_POST['name'] = 'name';
$_POST['password'] = '1234';
```
 ```php
private array $postKeys = [
        'name', 'email', 'password'
];
```

Then, you need to write your own method (methods) to validate data in Validator class.
For example:

```php
private function email($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false)
       $this->addError('email', "Email is not valid!"); //addError() adding your message and field name in errors[]
}
```

After that, you should add ```check($YourMethodName, ...$Arguments)``` into ```validate()```:

```php
public function validate()
{
    $this->check('email', $this->post['email']);
}
```
Then, you need write something like that:
```php
$validator = new Validator();
$validator->validate();
```
After, you can check if there are errors and, if they are, show it like this:

```php
if ($validator->hasErrors()) {
    $errors = $validator->getErrors();
    foreach ($errors as $key=>$value) {
        echo $key . " - " . $value . "</br>";
    }
} else {
    echo "success";
}
```


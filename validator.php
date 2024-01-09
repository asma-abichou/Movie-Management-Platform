<?php
class Validator{
    /*
     * data being validated
     * e.g['name'=>'Johnn', "age"=>'35']
     */
    private $data;
    /*
     * Validation errors e.g The name fields is required
     * e.g ['name'=>'This field is required']
     */
    private $errors;
    //rules array e.g ['name'=>'required', 'age'=>'number' , 'date'=>'date]
    private $validation_rules;

    private $messages = [
        'required' => "This field is required",
        'number' => "This field must be number",
        'email' => "This field must be an email",
        'date' => "This field must be a valid date"
        ];
    public function __construct($data, $validation_rules){
        $this->data = $data;
        $this->validation_rules = $validation_rules;
    }
    public function validate(){
        foreach($this->validation_rules as $field =>$rule){
            $field_value= $this->getFieldValue($field);
            $rule = ucfirst($rule);
            $method_to_call = "validate$rule";
           if($this->$method_to_call($field_value)) {
               //add error to our error array
              $this->addError($rule,$field);
           }
        }
        var_dump($this->errors);
    }
    public function getFieldValue($field){
        return $this->data[$field];
    }
    //Validates required attributes
    private function validateRequired($value){
        return !empty($value);

    }
    //validate number
    private function validateNumber($value){
        return is_numeric($value);
    }
    private function validateEmail($value){
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
    private function validateDate($value){
        $format = "Y-m-d";
        $d = DateTime::createFromFormat($format,$value);
        return $d && $d->format($format)===$value;
    }
    public function addError($rule,$field){
        $rule = strtolower($rule);
        $message = $this->messages[$rule];
        $this->errors[$field] = $message;
        Session::set('error', $this->errors);

    }
    public static function getErrorFields($field){
        if(Session::exists('errors')){

            $errors = Session::get('errors');
            if(key_exists($field,$errors)){
                $error = $errors[$field];
                unset($_SESSION['errors'][$field]);
                return $error;
            }
        }
    }
    public function passes(){
        return empty($this->errors);
    }
}

<?php
class validator{
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
            $field_value = $this->getFieldValue($field);
            echo "The $field value is $field_value";

        }
    }
    public function getFieldValue($field){
        return $this->data[$field];
    }

}

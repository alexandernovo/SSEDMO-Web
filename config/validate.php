<?php
require_once 'database.php';

function validate($fields, $validations)
{
    global $conn;
    $errors = [];
    foreach ($fields as $fieldName => $fieldValue) {
        if (isset($validations[$fieldName])) {
            foreach ($validations[$fieldName] as $validationType => $validationValue) {
                switch ($validationType) {
                    case 'required':
                        if (empty($fieldValue)) {
                            if (!isset($errors[$fieldName])) {
                                $errors[$fieldName] = 'This field is required';
                            }
                        }
                        break;
                    case 'email':
                        if (!filter_var($fieldValue, FILTER_VALIDATE_EMAIL)) {
                            if (!isset($errors[$fieldName])) {
                                $errors[$fieldName] = 'This field must be a valid email address';
                            }
                        }
                        break;
                    case 'min_length':
                        if (strlen($fieldValue) < $validationValue) {
                            if (!isset($errors[$fieldName])) {
                                $errors[$fieldName] = 'This field must be at least ' . $validationValue . ' characters long';
                            }
                        }
                        break;
                    case 'max_length':
                        if (strlen($fieldValue) > $validationValue) {
                            if (!isset($errors[$fieldName])) {
                                $errors[$fieldName] = 'This field must be no more than ' . $validationValue . ' characters long';
                            }
                        }
                        break;
                    case 'match':
                        if ($fieldValue != $fields[$validationValue]) {
                            if (!isset($errors[$fieldName])) {
                                $errors[$fieldName] = 'This field must match ' . $validationValue;
                            }
                        }
                        break;
                    case 'unique':
                        if (isset($validationValue['fieldName']) && isset($validationValue['tableName'])) {
                            if (!isUnique($conn, $validationValue['fieldName'], $validationValue['tableName'], $fieldValue)) {
                                if (!isset($errors[$fieldName])) {
                                    $errors[$fieldName] = 'This' . ' ' . $fieldName . ' ' . 'has been taken';
                                }
                            }
                        } else {
                            trigger_error("fieldName and/or tableName keys are not set for the unique validation of field {$fieldName}", E_USER_WARNING);
                        }
                        break;
                }
            }
        }
    }
    return $errors;
}


function isUnique($conn, $fieldName, $tableName, $fieldValue)
{
    $query = "SELECT * FROM $tableName WHERE $fieldName = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $fieldValue);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return false;
    } else {
        return true;
    }
}

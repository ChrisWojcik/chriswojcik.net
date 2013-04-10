<?php
require_once('../../../includes/bartlet-for-america/bootstrap.php');

// Set up arrays for the drop-down boxes
$months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
$years  = array('2012','2013','2014','2015','2016','2017','2018');
$states = array( "AK", "AL", "AR", "AZ", "CA", "CO", "CT", "DC",
                 "DE", "FL", "GA", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA",
                 "MA", "MD", "ME", "MI", "MN", "MO", "MS", "MT", "NC", "ND", "NE",
                 "NH", "NJ", "NM", "NV", "NY", "OH", "OK", "OR", "PA", "RI", "SC",
                 "SD", "TN", "TX", "UT", "VA", "VT", "WA", "WI", "WV", "WY");

// Set a default value for each field
$firstname = '';
$lastname = '';
$address1 = '';
$address2 = '';
$city = '';
$state = '---';
$zip = '';
$email = '';
$phone = '';
$amount = 0;
$otheramount = '';
$card = '';
$exp_mon = '---';
$exp_yr = '---';
$employer = '';
$occupation = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Remove any previous data in case we've been here before
    unset($_SESSION['form_data']);
    
    // Instantiate the validator object and add validation rules
    $validator = new FormValidator();
    
    $validator->addRule('firstname', 'Required field', 'required');
    $validator->addRule('lastname', 'Required field', 'required');
    $validator->addRule('address1', 'Required field', 'required');
    $validator->addRule('city', 'Required field', 'required');
    $validator->addRule('state', 'Please select', 'in-array', $states);
    $validator->addRule('zip', 'Required field', 'required');
    $validator->addRule('zip', 'Invalid zipcode', 'zip');
    $validator->addRule('email', 'Required field', 'required');
    $validator->addRule('email', 'Invalid email address', 'email');
    $validator->addRule('phone', 'Required filed', 'required');
    $validator->addRule('phone', 'Invalid phone number', 'phonenumber');       
    $validator->addRule('amount', 'Amount must be between $3 and $2,500', 'callback', 'amountCallback');
    $validator->addRule('card', 'Required field', 'required');
    $validator->addRule('card', 'Invalid credit card number', 'creditcard');
    $validator->addRule('exp_date', 'Invalid expiration date', 'callback', 'expDateCallback');
    $validator->addRule('employer', 'Required field', 'required');
    $validator->addRule('occupation', 'Required field', 'required');
    
    // Callback function for the amount field
    function amountCallback($value, $validator) {
        
        // If both amount and other amount are set, it's an error
        if (isset($value) && !empty($_POST['otheramount'])) {
            return false;
        }
        
        // Check if the amount is one of the allowed values
        if (isset($value) && in_array($value, array(10, 25, 50, 100, 250, 500, 1000))) {
            return true;
        }
        
        // Otherwise, validate the other amount field as currency
        $value = $validator->sanitize($_POST['otheramount']);
        
        // Optional $, groups of up to 3 digits with optional comma separation, 
        // only two digits after the decimal point
        if (!preg_match("/^\\\$?[0-9]{1,3}(,?[0-9]{3})*(\.[0-9]{2})?$/", $value)) {
            return false;
        }
        
        // Remove any commas or dollar signs so we have a pure number
        $value = preg_replace('/[$,]/', '', $value);
        
        // Use the built in validator function
        if ($validator->numberBetween($value, array(3, 2500))) {
            return true;
        }
        return false;
    }
    
    function expDateCallback()
    {
        // Month and year are evaluated together as one field
        $months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
        $years  = array('2012','2013','2014','2015','2016','2017','2018');
        
        if (in_array($_POST['exp_mon'], $months) && in_array($_POST['exp_yr'], $years)) {
            return true;
        }
        return false;
    }
    
    // Input the POST data and check it
    $validator->addEntries($_POST);
    $validator->validate();
    
    // Get the cleaned values
    $_SESSION['form_data'] = $validator->getEntries();
    
    // Redirect based on whether there were errors
    if ($validator->foundErrors()) {
        $errors = $validator->getErrors();
        $_SESSION['errors'] = $errors;
        $_SESSION['donate'] = false;
        header('Location: donate.php');
        exit();
    }
    else {
        $_SESSION['donate'] = true;
        header('Location: donate_success.php');
        exit();
    }
}

// If we were sent back here, more to do
if (isset($_SESSION['donate']) && $_SESSION['donate'] === false) {
    
    // Errors will only display once
    if (isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
        unset($_SESSION['errors']);
    }
    
    // Replace the default values
    foreach ($_SESSION['form_data'] as $key => $value) {
        ${$key} = $value;
    }
    
    // Don't allow otheramount and amount to both be selected
    if (!(empty($otheramount)) && $amount > 0) {
        $amount = 0;
        $otheramount = '';
    }
}

$title = 'Donate Today - Josiah Bartlet';
$body_id = 'donate';
include(DOC_ROOT . '/includes/bartlet-for-america/views/donate.php');
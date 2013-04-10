<?php
require_once('../../../includes/bartlet-for-america/bootstrap.php');

// Check that this is a valid context
if (!$_SESSION['donate']) {
    header('Location: index.php');
    exit();
}

// Grab the form data and reformat it for display
foreach ($_SESSION['form_data'] as $key => $value) {
    ${$key} = $value;
}

$hidden_chars = substr($card, 0, -4);
$show_chars = substr($card, -4);
$redacted = '';
for ($i = 1; $i <= strlen($hidden_chars); $i++) {
    $redacted .= '*';
}
$card = $redacted . $show_chars;

if (!isset($amount)) {
    $amount = $otheramount;
}
$amount = '$' . $amount;

$exp_date = $exp_mon . '/' . $exp_yr;

// We extracted all the data, so clear the session variables
unset($_SESSION['donate']);
unset($_SESSION['form_data']);

$title = 'Thank you for your donation - Josiah Bartlet';
$body_id = 'donate-success';
include(DOC_ROOT . '/includes/bartlet-for-america/views/donate_success.php');
<?php
require_once('../../../includes/bartlet-for-america/bootstrap.php');

$posts = $db->getAllPosts();
$title = 'Josiah Bartlet';
$body_id = 'home';

include(DOC_ROOT . '/includes/bartlet-for-america/views/home.php');
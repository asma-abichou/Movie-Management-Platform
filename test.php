<?php
include_once "Paginator.php";

$paginator = new Paginator(20,5);
$paginator->create_pagination_links();
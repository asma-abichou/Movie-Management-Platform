<?php
include_once "Paginator.php";

$paginator = new Paginator(20,5);
echo $paginator->get_pagination_links();
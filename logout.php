<?php
session_start();

require_once __DIR__ . '/helpers/url.php';  // path sesuaikan lokasi url.php

session_destroy();
header('Location: ' . base_url());
exit;

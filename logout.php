<?php
session_start();
session_unset(); // সব session ভেরিয়েবল clear
session_destroy(); // session বন্ধ

// রিডাইরেক্ট করো হোম পেজে
header("Location: index.php");
exit();
?>
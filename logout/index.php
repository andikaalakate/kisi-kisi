<?php
session_start();

session_destroy();

header("location:/kisi-kisi/login/");

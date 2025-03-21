<?php

sessionStart();
$_SESSION = [];
session_destroy();

redirect('/');
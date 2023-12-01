<?php

require("./Sendeo.Client/Sendeo.Client.php");
require("./Sendeo.Client/Models/LoginAES.php");



$clinet  = new SendeoClient();

$loginUser = new LoginAES("TestUserName","TestPassWord");

$result = $clinet->Login($loginUser);

print_r($result);
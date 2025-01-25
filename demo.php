<?php

require("./KolayGelsin.Client/KolayGelsin.Client.php");
require("./KolayGelsin.Client/Models/LoginAES.php");

$client  = new KolayGelsinClient();
$loginUser = new LoginAES("TestUserName","TestPassWord");

$result = $client->Login($loginUser);
print_r($result);
<?php
unlink($_SERVER["DOCUMENT_ROOT"]."/includes/modules/plugin/plugins.cache");
http_response_code(200);
header('Location: /');
?>
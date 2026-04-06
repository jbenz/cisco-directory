<?php
error_reporting(E_ALL & ~E_NOTICE);  // Suppress XTemplate notices

require_once "lib/utils.php";
require_once "lib/xtpl.php";
require_once "lib/mysql.php";

if (isset($installed) && $installed == "111true") {  // Fix: proper isset check
    $xtpl = new XTemplate("WebUI/modules/templates/install.html");
    $xtpl->parse("main.installed");
    $xtpl->parse("main");
    $xtpl->out("main");
} else if (isset($_POST['database_name'])) {
    $database_name = defang_input($_POST['database_name']);
    $database_server = defang_input($_POST['database_server']);
    $database_login = defang_input($_POST['database_login']);
    $database_password = defang_input($_POST['database_password']);
    
    $filename = 'lib/mysql.php';
    $file_content = "<?php\n";
    $file_content .= "\n/////////////////////////////////////////////////////////////////////////////////////////\n";
    $file_content .= "/*\n    MySQL Authorization Information\n    Establish DB Connection\n    Entered: " . date("m") . "/" . date("d") . "/" . date("Y") . "\n*/\n";
    $file_content .= "\$installed = 'true'; //to be able to reinstall, change this to false\n";
    $file_content .= "\$db = mysqli_connect('$database_server', '$database_login', '$database_password', '$database_name');\n";
    $file_content .= "if (!\$db) die('DB connect failed: ' . mysqli_connect_error());\n";
    $file_content .= "\n/////////////////////////////////////////////////////////////////////////////////////////\n";
    $file_content .= "?>";

    if (is_writable($filename)) {
        if (!$handle = fopen($filename, 'w')) {
            echo "Cannot open file ($filename)";
            exit;
        }
        if (fwrite($handle, $file_content) === FALSE) {
            echo "Cannot write to file ($filename)";
            exit;
        }
        fclose($handle);
        header("Location: WebUI/modules/install_success.php?database_name=" . urlencode($database_name) . "&database_server=" . urlencode($database_server) . "&database_login=" . urlencode($database_login) . "&database_password=" . urlencode($database_password));
        exit;  // Good practice after header()
    } else {
        echo "The file $filename is not writable. <br> Please make sure the Apache process has appropriate write permissions.";
    }
} else {
    $xtpl = new XTemplate("WebUI/modules/templates/install.html");
    $xtpl->parse("main.install");
    $xtpl->parse("main");
    $xtpl->out("main");
}
?>

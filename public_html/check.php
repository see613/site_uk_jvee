
<?php

$password = 'qwerty';
$pathToWww = '..';
$pathToApp = '../../app';

$passIsCorrect = !empty($_POST['password']) && $_POST['password'] == $password;

?>



<form method="post">
    <?php if($passIsCorrect): ?>
        <input type="hidden" name="password" value="<?php echo $password?>" />
        <input type="submit" value="Refresh page" />
    <?php else: ?>
        <label for="password">Enter password: </label>
        <input id="password" type="password" name="password" />
        <input type="submit" value="Ok" />
    <?php endif; ?>
</form>



<?php

if ($passIsCorrect) {
    $verifier = new Verifier();
    $verifier->checkOnExisting($pathToWww.'/.htaccess');
    $verifier->checkOnExistingAndPermissions($pathToWww.'/assets', 755);
    $verifier->checkOnExistingAndPermissions($pathToWww.'/admin/assets', 755);
    $verifier->checkOnExistingAndPermissions($pathToApp.'/runtime', 755);
    $verifier->checkTimeZone($pathToApp.'/config/settings.php');
    $verifier->checkMinimalPhpVersion('5.3');
    $verifier->checkRequiredExtensions(array('mbstring', 'memcached', 'pdo'));
    $verifier->checkRecommendedExtensions(array('pdo_mysql', 'apc', 'mcrypt'));
}


class Verifier {
    const ERROR = 'bs-callout-danger';
    const WARNING = 'bs-callout-warning';
    const SUCCESS = 'bs-callout-success';


    public function checkMinimalPhpVersion($version) {
        if (version_compare(phpversion(), $version, '>=')) {
            $this->showSuccess("php version is ".phpversion()." ($version is required)");
        }
        else {
            $this->showError("php version is ".phpversion()." ($version is required)");
        }
    }

    public function checkRequiredExtensions($extensions) {
        foreach ($extensions as $item) {
            $this->checkRequiredExtension($item);
        }
    }

    public function checkRecommendedExtensions($extensions) {
        foreach ($extensions as $item) {
            $this->checkRecommendedExtension($item);
        }
    }

    public function checkRequiredExtension($extension) {
        if (extension_loaded($extension)) {
            $this->showSuccess("php has a required extension \"$extension\"");
        }
        else {
            $this->showError("php doesn't have a required extension \"$extension\"");
        }
    }

    public function checkRecommendedExtension($extension) {
        if (extension_loaded($extension)) {
            $this->showSuccess("php has a recommended extension \"$extension\"");
        }
        else {
            $this->showWarning("php doesn't have a recommended extension \"$extension\"");
        }
    }

    public function checkTimeZone($path) {
        if ( $this->checkOnExisting($path) ) {
            include_once($path);

            if ( date_default_timezone_get() ) {
                $this->showSuccess("default timezone is ".date_default_timezone_get());
            }
            else {
                $this->showError("default timezone isn't defined");
            }
        }
    }

    public function checkOnExistingAndPermissions($path, $permissions) {
        if ( $this->checkOnExisting($path) ) {
            $this->checkOnPermissions($path, $permissions);
        }
    }

    public function checkOnExisting($path) {
        if ( $this->fileExists($path) ) {
            $this->showSuccess("file/folder \"$path\" exists");
            return true;
        }
        else {
            $this->showError("file/folder \"$path\" doesn't exist");
            return false;
        }
    }

    public function checkOnPermissions($path, $permissions) {
        if ( $this->fileHasPermissions($path, $permissions) ) {
            $this->showSuccess("file/folder \"$path\" has the permissions ".$this->getPermissions($path)." ($permissions is required)");
            return true;
        }
        else {
            $this->showError("file/folder \"$path\" has the permissions ".$this->getPermissions($path)." ($permissions is required)");
            return false;
        }
    }

    private function fileHasPermissions($path, $requiredPermissions) {
        return $this->comparePermissions( $this->getPermissions($path), $requiredPermissions );
    }

    private function comparePermissions($permissions, $requiredPermissions) {
        $permissions = octdec($permissions);
        $requiredPermissions = octdec($requiredPermissions);

        return !( ($requiredPermissions & $permissions) != $requiredPermissions );
    }

    private function getPermissions($path) {
        return (int) substr(sprintf('%o', fileperms($path)), -3);
    }

    private function fileExists($path) {
        return file_exists($path);
    }

    private function showSuccess($message) {
        $this->showMessage($message, self::SUCCESS);
    }

    private function showWarning($message) {
        $this->showMessage($message, self::WARNING);
    }

    private function showError($message) {
        $this->showMessage($message, self::ERROR);
    }

    private function showMessage($message, $type) {
        echo "<div class=\"bs-callout $type\">
                <p> $message </p>
              </div>";
    }
}
?>


<style type="text/css">
    .bs-callout {
        border-left: 3px solid #EEEEEE;
        margin: 5px 0;
        padding: 10px;
    }
    .bs-callout-danger {
        background: #F2DEDE;
        border-color: #D9534F;
    }
    .bs-callout-success {
        background: #DFF0D8;
        border-color: #53D94F;
    }
    .bs-callout-warning {
        background: #fcf8f2;
        border-color: #f0ad4e;
    }
</style>
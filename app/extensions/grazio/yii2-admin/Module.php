<?php

namespace grazio\admin;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'grazio\admin\controllers';
    private $_grazioPackages;
    private $_nav;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->modules = $this->getAdminModules();

        Yii::$app->getView()->theme->pathMap = [
            '@grazio/admin/views' => '@grazio/adminlte/views'
        ];

        $this->viewPath = '@grazio/admin/views';
        $this->layout = 'main';

        $adminUser = [
            'identityClass' => 'grazio\system\models\Admin',
            'idParam' => '__adminId',
            'identityCookie' => ['name' => '__AdminIdentity', 'httpOnly' => true],
            'enableAutoLogin' => true,
            'loginUrl' => ['admin/default/login']
        ];

        Yii::configure(Yii::$app->user, $adminUser);

    }

    private function getAdminModules()
    {
        $adminModules = [];
        foreach ($this->getGrazioPackages() as $packageClassName) {
            $package = Yii::createObject($packageClassName);
            if (($adminModuleParams = $package->getAdminModule()) !== false) {
                $adminModules = array_merge($adminModules, $adminModuleParams);
            }
        }
        return $adminModules;
    }

    private function setGrazioPackages()
    {
        $extensions = Yii::$app->extensions;

        $grazioPackages = [];

        foreach ($extensions as $name => $params) {

            foreach ($params['alias'] as $alias => $path) {
                $filePath = $alias . '/' . 'Package.php';

                if (!file_exists(Yii::getAlias($filePath))) {
                    continue;
                }

                $packageClassName = str_replace(['.php', '/', '@'], ['', '\\', ''], $filePath);
                $packageClassReflection = $this->getReflection($packageClassName);

                if ($packageClassReflection !== false && $packageClassReflection->implementsInterface('grazio\core\package\PackageInterface')) {
                    $grazioPackages[] = $packageClassReflection->getName();
                }
            }
        }
        return $grazioPackages;
    }

    private function getGrazioPackages()
    {
        if (empty($this->_grazioPackages)) {
            $this->_grazioPackages = $this->setGrazioPackages();
        }
        return $this->_grazioPackages;
    }

    /**
     * @param $className
     * @return bool|\ReflectionClass
     */
    protected function getReflection($className)
    {
        try {
            if (in_array($className, ['yii\requirements\YiiRequirementChecker', 'yii\helpers\Markdown'])) {
                return false;
            }
            $reflection = new \ReflectionClass($className);
        } catch (\Exception $e) {
            return false;
        }
        return $reflection;
    }

    public function setNav()
    {
        $menu = self::menu();
        foreach ($this->getAdminModules() as $adminModule) {
            $menu = array_merge($menu, $adminModule['class']::menu());
        }
        $menu = $this->normalizeItems($menu);
        return $this->_nav = $menu;
    }


    public function getNav()
    {
        if (empty($this->_nav)) {
            $this->_nav = $this->setNav();
        }
        return $this->_nav;
    }

    protected function normalizeItems($items)
    {
        foreach ($items as $i => $item) {
            if (isset($item['url']) && is_array($item['url'])) {
                $route = $item['url'][0];
                $route = Yii::getAlias((string)$route);

                if (strncmp($route, '/', 1) === 0) {
                    $items[$i]['url'][0] = '/' . $this->uniqueId . $route;
                }
            }
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items']);
            }

        }
        return array_values($items);
    }

    public static function menu()
    {
        return
            [
                ['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/']]
            ];
    }
}

<?php

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Installer\InstallerHelper;


if (!class_exists('PlgextensioninstallerInstallerScript')) {
    /**
     * Class PlgextensioninstallerInstallerScript
     */
    class PlgextensioninstallerInstallerScript
    {
        /**
         * @var array
         */
        protected $packages = array();

        /**
         * @var
         */
        protected $sourcedir;

        /**
         * @var
         */
        protected $installerdir;

        /**
         * @var
         */
        protected $manifest;

        /**
         * @var
         */
        protected $parent;

        /**
         * @param object $parent Prent object
         *
         * @return bool
         */
        public function install($parent)
        {
            $this->cleanErrors();

            jimport('joomla.filesystem.file');
            jimport('joomla.filesystem.folder');
            jimport('joomla.installer.helper');

            if (!class_exists('WizardInstaller')) {
                include_once $this->installerdir . '/WizardInstaller.php';
            }

            $retval = true;
            ob_get_clean();

            // Cycle through items and install each
            if (count($this->manifest->items->children())) {
                foreach ($this->manifest->items->children() as $item) {
                    $folder = $this->sourcedir . '/' . $item->dirname;

                    if (is_dir($folder)) {
                        // if its actually a directory then fill it up
                        $package                = Array();
                        $type = (string) $item['type'];
                        $package['dir']         = $folder;
                        $package['type']        = InstallerHelper::detectType($folder);
                        $package['installer']   = new WizardInstaller();
                        $package['name']        = (string) $item->name;
                        $package['state']       = 'Success';
                        $package['description'] = (string) $item->description;
                        $package['msg']         = '';
                        $package['type']        = ucfirst($type);

                        $package['installer']->setItemInfo($item);

                        // add installer to static for possible rollback.
                        $this->packages[] = $package;

                        $package['installer']->setAdapter($type);

                        if (!@$package['installer']->install($package['dir'])) {
                            $messages = Factory::getApplication()->getMessageQueue(true);
                            if ($messages && is_array($messages) && count($messages) > 0) {
                                $package['msg'] .= $messages[0]['message'];
                            }

                            WizardInstallerEvents::addMessage($package, WizardInstallerEvents::STATUS_ERROR, $package['msg']);
                            break;
                        }

                        if ($package['installer']->getInstallType() == 'install') {
                            WizardInstallerEvents::addMessage($package, WizardInstallerEvents::STATUS_INSTALLED);
                        } else {
                            WizardInstallerEvents::addMessage($package, WizardInstallerEvents::STATUS_UPDATED);
                        }
                    } else {
                        $package                = Array();
                        $package['dir']         = $folder;
                        $package['name']        = (string) $item->name;
                        $package['state']       = 'Failed';
                        $package['description'] = (string) $item->description;
                        $package['msg']         = '';
                        $package['type']        = ucfirst((string) $item['type']);

                        WizardInstallerEvents::addMessage(
                            $package,
                            WizardInstallerEvents::STATUS_ERROR, Text::_('JLIB_INSTALLER_ABORT_NOINSTALLPATH')
                        );
                        break;
                    }
                }
            } else {
                $parent->getParent()->abort(
                    Text::sprintf(
                        'JLIB_INSTALLER_ABORT_PACK_INSTALL_NO_FILES',
                        Text::_('JLIB_INSTALLER_' . strtoupper($this->route))
                    )
                );
            }
            return $retval;
        }

        /**
         * @param object $parent Parent object
         *
         * @return bool
         */
        public function update($parent)
        {
            return $this->install($parent);
        }

        /**
         * @param string $type   Type extension
         * @param object $parent Parent object
         *
         * @return bool
         */
        public function preflight($type, $parent)
        {
            $this->setup($parent);

            //Load Event Handler.
            if (!class_exists('WizardInstallerEvents')) {
                include_once $this->installerdir . '/WizardInstallerEvents.php';

                $dispatcher = Factory::getApplication()->getDispatcher();
                $plugin = new WizardInstallerEvents($dispatcher);
                $plugin->setTopInstaller($this->parent->getParent());
            }

            jimport('joomla.filesystem.file');
            jimport('joomla.filesystem.folder');

            $themeName = 'icm_praise';
            $pluginName = 'nicepage';
            $tmpExtDir = dirname(__FILE__);
            $tmpDir = dirname(dirname(__FILE__));
            $newExtDir = $tmpDir . '/install_extensions/package';
            $newContentDir = $tmpDir . '/install_extensions/content';
            $tmpThemeExtFile = $tmpExtDir . '/' . $themeName . '/extensions/' . $pluginName . '.zip';
            if (file_exists($tmpThemeExtFile)) {
                if (!file_exists($newExtDir)) {
                    Folder::create($newExtDir);
                }
                // remove old content
                if (file_exists($newContentDir)) {
                    Folder::delete($newContentDir);
                }
                Folder::copy($tmpExtDir . '/' . $themeName . '/content', $newContentDir);
                File::copy($tmpExtDir . '/wizard.php', dirname($newExtDir) . '/wizard.php');
                try {
                    $zip = new ZipArchive;
                    if ($zip->open($tmpThemeExtFile) === true) {
                        $zip->extractTo($newExtDir);
                        $zip->close();
                    }
                    //JArchive::extract($tmpThemeExtFile, $newExtDir);
                } catch (Exception $e) {
                    WizardInstallerEvents::addMessage(
                        array('name' => ''),
                        WizardInstallerEvents::STATUS_ERROR,
                        'Error Installer Extensions'
                    );
                }
            }
        }

        /**
         * @param string $type   Type extension
         * @param object $parent Parent object
         */
        public function postflight($type, $parent)
        {
            $conf = Factory::getConfig();
            $conf->set('debug', false);
            $parent->getParent()->abort();
        }

        /**
         * @param null $msg  Text message
         * @param null $type Type extension
         */
        public function abort($msg = null, $type = null)
        {
            if ($msg) {
                Factory::getApplication()->enqueueMessage($msg, 'error');
            }
            foreach ($this->packages as $package) {
                $package['installer']->abort(null, $type);
            }
        }

        /**
         * @param object $parent Parent object
         */
        protected function setup($parent)
        {
            $this->parent       = $parent;
            $this->sourcedir    = $parent->getParent()->getPath('source');
            $this->manifest     = $parent->getParent()->getManifest();
            $this->installerdir = $this->sourcedir . '/installer';
        }

        /**
         * Clean errors
         */
        protected function cleanErrors()
        {
            $app               = new WizardInstallerJAdministratorWrapper(Factory::getApplication());
            $enqueued_messages = $app->getMessageQueue();
            $other_messages    = array();

            if (!empty($enqueued_messages) && is_array($enqueued_messages)) {
                foreach ($enqueued_messages as $enqueued_message) {
                    if (!($enqueued_message['message'] == Text::_('JLIB_INSTALLER_ERROR_NOTFINDXMLSETUPFILE') && $enqueued_message['type']) == 'error') {
                        $other_messages[] = $enqueued_message;
                    }
                }
            }
            $app->setMessageQueue($other_messages);
        }
    }

    if (!class_exists('WizardInstallerJAdministratorWrapper')) {
        /**
         * Class WizardInstallerJAdministratorWrapper
         */
        class WizardInstallerJAdministratorWrapper
        {
            /**
             * @var JApplicationCms
             */
            protected $app;

            /**
             * WizardInstallerJAdministratorWrapper constructor.
             *
             * @param JApplicationCms $app Application object
             */
            public function __construct(JApplicationCms $app)
            {
                $this->app = $app;
            }

            /**
             * @param bool $clear Clear variable
             *
             * @return mixed
             */
            public function getMessageQueue($clear = false)
            {
                return $this->app->getMessageQueue();
            }

            /**
             * @param array $messages Messages list
             */
            public function setMessageQueue($messages)
            {
                $this->app->_messageQueue = $messages;
            }
        }
    }
}

<?php

require_once 'WhatsNewFeature.php';

class WhatsnewPlugin extends StudIPPlugin implements SystemPlugin, PortalPlugin {

    public function __construct() {
        parent::__construct();
        $this->promt();
    }

    public function getPortalTemplate() {

        PageLayout::addStylesheet($this->getPluginURL() . '/assets/style.css');
        PageLayout::addScript($this->getPluginURL() . '/assets/application.js');
        $this->template_factory = new Flexi_TemplateFactory(dirname(__FILE__) . '/templates/');
        $template = $this->template_factory->open('show');

        $images = array();

        // Find all the folders
        foreach (glob(__DIR__ . '/images/*', GLOB_ONLYDIR) as $folder) {

            // Fetch all images
            foreach (glob($folder . "/*") as $image) {
                $images[] = $this->getPluginURL() . "/images/" . basename($folder) . "/" . basename($image);
            }
        }
        $template->set_attribute('images', $images);
        return $template;
    }

    public function getPluginName() {
        return _('Willkommen bei Stud.IP');
    }

    public function promt() {

        $feature = new WhatsNewFeature($GLOBALS['user']->id);

        if (version_compare($GLOBALS['SOFTWARE_VERSION'], $feature->version)) {

            // Prepare the image array
            $images = array();

            // Find all the folders
            foreach (glob(__DIR__ . '/images/*', GLOB_ONLYDIR) as $folder) {
                // Check if needs to be displayed
                if (((version_compare(basename($folder), $feature->version) >= 0) && (version_compare($GLOBALS['SOFTWARE_VERSION'], basename($folder))) >= 0)) {

                    // Fetch all images
                    foreach (glob($folder . "/*") as $image) {
                        $images[] = $this->getPluginURL() . "/images/" . basename($folder) . "/" . basename($image);
                    }
                }
            }

            if ($images) {
                PageLayout::addStylesheet($this->getPluginURL() . '/assets/style.css');
                PageLayout::addScript($this->getPluginURL() . '/assets/application.js');

                // Do the twist
                $this->template_factory = new Flexi_TemplateFactory($this->getPluginPath() . '/templates');
                $template = $this->template_factory->open('show');
                $template->set_attribute('images', $images);
                PageLayout::addBodyElements($template->render());
            } else {
                $_SESSION['whatsnew_done'] = true;
            }
        } else {
            $_SESSION['whatsnew_done'] = true;
        }
    }

    public function getTemplate() {
        // Prepare the image array
        $images = array();

        // Find all the folders
        foreach (glob(__DIR__ . '/images/*', GLOB_ONLYDIR) as $folder) {
            // Check if needs to be displayed
            if (((version_compare(basename($folder), $feature->version) >= 0) && (version_compare($GLOBALS['SOFTWARE_VERSION'], basename($folder))) >= 0)) {

                // Fetch all images
                foreach (glob($folder . "/*") as $image) {
                    $images[] = $this->getPluginURL() . "/images/" . basename($folder) . "/" . basename($image);
                }
            }
        }

        if ($images) {
            PageLayout::addStylesheet($this->getPluginURL() . '/assets/style.css');
            PageLayout::addScript($this->getPluginURL() . '/assets/application.js');

            // Do the twist
            $this->template_factory = new Flexi_TemplateFactory($this->getPluginPath() . '/templates');
            $template = $this->template_factory->open('show');
            $template->set_attribute('images', $images);
            return $template->render();
        }
    }

    public function perform() {

        // Update last viewed version
        $feature = new WhatsNewFeature($GLOBALS['user']->id);
        $feature->version = $GLOBALS['SOFTWARE_VERSION'];
        $feature->store();
    }

}

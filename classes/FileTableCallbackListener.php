<?php

namespace Hschottm\Tags\DataContainer;

use Contao\Controller;
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\Database;
use Contao\DataContainer;
use Contao\Model;

class FileTableCallbackListener {
    /**
     * @Callback(table="tl_files", target="config.oncopy")
     */
    public function onCopyCallback($intId, DataContainer $dc)
    {
        // If this is not the backend than return
        if (TL_MODE != 'BE') {
            return;
        }

		$level = LogLevel::INFO;
		$logger = static::getContainer()->get('monolog.logger.contao');
        $logger->log($level, "Callback called for " . $intId, array());

        $strTable = $dc->table;
        $strModel = '\\'.Model::getClassFromTable($strTable);

        // Return if the class does not exist (#9 thanks to tsarma)
        if (!class_exists($strModel)) {
            return;
        }

        // Get object from model
        $objModel = $strModel::findByPk($intId);

        if ($objModel !== null) {
            $arrData = $objModel->row();

            if (is_array($arrData) && count($arrData) > 0) {
                // Load current data container
                $logger->log($level, "Hallo: " . print_r($arrData, true), array());
                Controller::loadDataContainer($strTable);

                foreach ($arrData as $strField => $varValue) {
                }
            }

            // Save model object
            $objModel->save();
        }
    }

}

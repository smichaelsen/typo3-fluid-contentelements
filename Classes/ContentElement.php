<?php
namespace AppZap\FluidContentelements;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class ContentElement {

	/**
	 * Use in ext_localconf.php
	 *
	 * @param string $extensionKey
	 */
	public static function addTyposcriptConstants($extensionKey) {
		$constants = trim('
			plugin.' . self::getPluginNamespace($extensionKey) . '.view {
				templateRootPath = EXT:' . $extensionKey . '/Resources/Private/Fluid/ContentElements/
				partialRootPath = EXT:' . $extensionKey . '/Resources/Private/Fluid/ContentElements/Partials/
				layoutRootPath = EXT:' . $extensionKey . '/Resources/Private/Fluid/ContentElements/Layouts/
			}
		');
		ExtensionManagementUtility::addTypoScript($extensionKey, 'constants', $constants);
	}

	/**
	 * Use in ext_localconf.php
	 *
	 * @param string $extensionKey
	 * @param string $title
	 * @param bool $standardHeader
	 */
	public static function addContentElementTyposcript($extensionKey, $title, $standardHeader = TRUE) {
		$filename = str_replace(' ', '', $title);
		$typename = self::getPluginNamespace($extensionKey) . '_' . strtolower(str_replace(' ', '_', $title));
		// Frontend
		$setup = trim('
			tt_content.' . $typename . ' = COA
			tt_content.' . $typename . ' {
				' . ($standardHeader ? '10 = < lib.stdheader' : '') . '
				20 = FLUIDTEMPLATE
				20 {
					file = {$plugin.' . self::getPluginNamespace($extensionKey) . '.view.templateRootPath}' . $filename . '.html
					partialRootPath = {$plugin.' . self::getPluginNamespace($extensionKey) . '.view.partialRootPath}
					layoutRootPath = {$plugin.' . self::getPluginNamespace($extensionKey) . '.view.layoutRootPath}
				}
			}
		');
		ExtensionManagementUtility::addTypoScript($extensionKey, 'setup', $setup, 'defaultContentRendering');
	}

	/**
	 * Use in ext_tables.php
	 *
	 * @param string $extensionKey
	 * @param string $title
	 * @param string $showItemList
	 */
	public static function registerContentElement($extensionKey, $title, $showItemList = NULL) {
		$filename = str_replace(' ', '', $title);
		$typename = self::getPluginNamespace($extensionKey) . '_' . strtolower(str_replace(' ', '_', $title));

		// Backend
		ExtensionManagementUtility::addPlugin(
			array(self::localLangPath($extensionKey, $typename) . '.title', $typename),
			'CType'
		);
		$pageTs = trim('
			mod.wizards.newContentElement.wizardItems.common {
				elements.' . $typename . ' {
					icon = ../typo3conf/ext/' . $extensionKey . '/Resources/Public/Icons/ContentElements/' . $filename . '.png
					title = ' . self::localLangPath($extensionKey, $typename) . '.title
					description = ' . self::localLangPath($extensionKey, $typename) . '.description
					tt_content_defValues.CType = ' . $typename . '
				}
				show := addToList(' . $typename . ')
			}
		');
		ExtensionManagementUtility::addPageTSConfig($pageTs);
		if (is_null($showItemList)) {
			$showItemList = $GLOBALS['TCA']['tt_content']['types']['textpic']['showitem'];
		}
		$GLOBALS['TCA']['tt_content']['types'][$typename]['showitem'] = $showItemList;
	}

	/**
	 * @param string $extensionKey
	 * @param string $typename
	 *
	 * @return string
	 */
	protected static function localLangPath($extensionKey, $typename) {
		return 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_contentelements.xlf:' . $typename;
	}

	/**
	 * @param string $extensionKey
	 * @return string
	 */
	protected static function getPluginNamespace($extensionKey) {
		return 'tx_' . str_replace('_', '', $extensionKey);
	}

}
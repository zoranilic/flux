<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Claus Due <claus@wildside.dk>, Wildside A/S
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *****************************************************************/

/**
 * Base class for all FlexForm related ViewHelpers
 *
 * @package Flux
 * @subpackage Core/ViewHelper
 */
abstract class Tx_Flux_Core_ViewHelper_AbstractFlexformViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @var Tx_Flux_Service_FluxService
	 */
	protected $configurationService;

	/**
	 * @param Tx_Flux_Service_FluxService $configurationService
	 * @return void
	 */
	public function injectConfigurationService(Tx_Flux_Service_FluxService $configurationService) {
		$this->configurationService = $configurationService;
	}

	/**
	 * @return void
	 */
	public function render() {
		$component = $this->getComponent();
		$container = $this->getContainer();
		$container->add($component);
		$this->setContainer($component);
		$this->renderChildren();
		$this->setContainer($container);
	}

	/**
	 * @return Tx_Flux_Form
	 */
	protected function getForm() {
		if (FALSE === $this->viewHelperVariableContainer->exists('Tx_Flux_ViewHelpers_FlexformViewHelper', 'form')) {
			/** @var Tx_Flux_Form $form */
			$form = $this->objectManager->get('Tx_Flux_Form');
			$this->viewHelperVariableContainer->add('Tx_Flux_ViewHelpers_FlexformViewHelper', 'form', $form);
		}
		return $this->viewHelperVariableContainer->get('Tx_Flux_ViewHelpers_FlexformViewHelper', 'form');
	}

	/**
	 * @param string $gridName
	 * @return Tx_Flux_Form
	 */
	protected function getGrid($gridName = 'grid') {
		if (FALSE === $this->viewHelperVariableContainer->exists('Tx_Flux_ViewHelpers_FlexformViewHelper', 'grids')) {
			$grid = $this->getForm()->createContainer('Grid', $gridName, 'Grid');
			$grids = array($gridName => $grid);
			$this->viewHelperVariableContainer->add('Tx_Flux_ViewHelpers_FlexformViewHelper', 'grids', $grids);
		}
		$grids = $this->viewHelperVariableContainer->get('Tx_Flux_ViewHelpers_FlexformViewHelper', 'grids');
		if (FALSE === isset($grids[$gridName])) {
			$grid = $this->getForm()->createContainer('Grid', $gridName, 'Grid');
			$grids[$gridName] = $grid;
			$this->viewHelperVariableContainer->addOrUpdate('Tx_Flux_ViewHelpers_FlexformViewHelper', 'grids', $grids);
		}
		return $grids[$gridName];
	}

	/**
	 * @return Tx_Flux_Form_ContainerInterface
	 */
	protected function getContainer() {
		if (FALSE === $this->viewHelperVariableContainer->exists('Tx_Flux_ViewHelpers_FlexformViewHelper', 'container')) {
			$form = $this->getForm();
			$container = $form->last();
			$this->setContainer($container);
		}
		return $this->viewHelperVariableContainer->get('Tx_Flux_ViewHelpers_FlexformViewHelper', 'container');
	}

	/**
	 * @param Tx_Flux_Form_FormInterface
	 * @return void
	 */
	protected function setContainer(Tx_Flux_Form_FormInterface $container) {
		$this->viewHelperVariableContainer->addOrUpdate('Tx_Flux_ViewHelpers_FlexformViewHelper', 'container', $container);
	}

}

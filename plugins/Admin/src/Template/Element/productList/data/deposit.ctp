<?php
/**
 * FoodCoopShop - The open source software for your foodcoop
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since         FoodCoopShop 2.2.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 * @author        Mario Rothauer <office@foodcoopshop.com>
 * @copyright     Copyright (c) Mario Rothauer, https://www.rothauer-it.com
 * @link          https://www.foodcoopshop.com
 */

use Cake\Core\Configure;

echo '<td>';
    if (empty($product->product_attributes)) {
        echo '<div class="table-cell-wrapper deposit">';
        if ($appAuth->isSuperadmin() || $appAuth->isAdmin() || Configure::read('app.isDepositPaymentCashless')) {
            echo $this->Html->getJqueryUiIcon($this->Html->image($this->Html->getFamFamFamPath('page_edit.png')), [
                'class' => 'product-deposit-edit-button',
                'title' => __d('admin', 'change_deposit')
            ], 'javascript:void(0);');
        }
        if ($product->deposit > 0) {
            echo '<span class="deposit-for-dialog">';
            echo $this->Number->formatAsDecimal($product->deposit);
            echo '</span>';
        }
        echo '</div>';
    }
echo '</td>';

?>
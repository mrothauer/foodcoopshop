<?php
/**
 * FoodCoopShop - The open source software for your foodcoop
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since         FoodCoopShop 2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 * @author        Mario Rothauer <office@foodcoopshop.com>
 * @copyright     Copyright (c) Mario Rothauer, http://www.rothauer-it.com
 * @link          https://www.foodcoopshop.com
 */
use Cake\Core\Configure;

echo '<div class="timebased-currency-product-info">';
    $titleForOverlay =
        '<span>Anteil in €: ' . $this->Html->formatAsDecimal($money).'</span><br />' .
        '<span>Anteil in ' . Configure::read('appDb.FCS_TIMEBASED_CURRENCY_NAME') . ': ' . $this->Html->formatAsDecimal($time) . Configure::read('appDb.FCS_TIMEBASED_CURRENCY_SHORTCODE').'</span>'
    ;
    echo '<div title="'.$titleForOverlay.'">davon ' . $maxPercentage . '% in ' . Configure::read('appDb.FCS_TIMEBASED_CURRENCY_NAME') . '</div>';
echo '</div>';
?>
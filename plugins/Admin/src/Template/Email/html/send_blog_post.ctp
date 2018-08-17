<?php
use Cake\Core\Configure;

?>
<?php echo $this->element('email/tableHead'); ?>
    <tbody>

    <tr>
        <td>Neuer Blog-Artikel für dich</td>
    </tr>
    <tr>
        <td>
            <a href="<?php echo $link; ?>">Zum Blog-Artikel</a>
        </td>
    </tr>

    </tbody>
<?php echo $this->element('email/tableFoot'); ?>
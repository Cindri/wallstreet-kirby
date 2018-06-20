<?php
?>

<style>

    #recipients-widget {
        overflow-y: scroll;
        max-height:800px;
    }

    table.recipients {
        border-collapse:collapse;
        font-size:9pt;
    }

    table.recipients td {
        border: 1px solid darkgray;
        padding:2px;
        max-width:160px;
        overflow-x: hidden;
    }
</style>

<script type="text/javascript">
    function del(obj) {
        var $obj = $(obj);
        var recipientUid = $obj.parent().parent().data('recipientuid');

        $.get(
            '<?= site()->url() . '/newsletter/test' ?>',
            { unique: recipientUid }
        );
    }
</script>

<table class="recipients">
    <tr>
        <th>E-Mail</th>
        <th>Fax</th>
        <th>Angemeldet am</th>
        <th>Bestätigt am</th>
        <th>Abgemeldet am</th>
        <th>Optionen</th>
    </tr>
<?php
foreach ($recipients as $recipient):
    ?>
    <tr data-recipientuid="<?= $recipient->uniqueid() ?>" id="recipient-<?= $recipient->ID() ?>">
        <td title="<?= $recipient->email() ?>"><?= $recipient->email() ?></td>
        <td title="<?= $recipient->fax() ?>"><?= $recipient->fax() ?></td>
        <td><?= DateTime::createFromFormat('U', $recipient->datum())->format('d.m.Y'); ?></td>
        <td><?= DateTime::createFromFormat('U', $recipient->date_confirmed())->format('d.m.Y'); ?></td>
        <td><?= DateTime::createFromFormat('U', $recipient->date_unregister())->format('d.m.Y'); ?></td>
        <td><i class="icon fa fa-trash" onclick="del(this)"></i></td>
    </tr>
<?php
endforeach;
?>
</table>

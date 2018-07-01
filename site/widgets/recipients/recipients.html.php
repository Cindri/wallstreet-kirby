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

    table.recipients td, table.recipients th {
        border: 1px solid darkgray;
        padding:2px;
        overflow-x: hidden;
    }

</style>

<script type="text/javascript">

    function signout(obj) {
        if (!confirm('Sicher dass Sie den Nutzer vom Newsletter abmelden möchten? Dieser Vorgang kann nur vom Entwickler rückgängig gemacht werden!')) {
            return false;
        }
        var $obj = $(obj);
        var id = $obj.parent().parent().prop('id');
        var recipientUid = $obj.parent().parent().data('recipientuid');

        $.get(
            '<?= site()->url() . '/newsletter/signout' ?>',
            { unique: recipientUid },
            function(data) {
                $('.recipients').find('#' + id).css('text-decoration', 'line-through');
            }
        );
    }

    function deleteData(obj) {
        if (!confirm('Sicher dass Sie den Datensatz des Nutzers? Dieser Vorgang kann nicht rückgängig gemacht werden, auch nicht vom Entwickler!')) {
            return false;
        }
        var $obj = $(obj);
        var id = $obj.parent().parent().prop('id');
        var recipientUid = $obj.parent().parent().data('recipientuid');

        $.get(
            '<?= site()->url() . '/newsletter/delete' ?>',
            { unique: recipientUid },
            function(data) {
                $('.recipients').find('#' + id).hide();
            }
        );
    }

</script>

<table class="recipients">
    <tr>
        <th>ID</th>
        <th>E-Mail</th>
        <th>Fax</th>
        <th>Anmeldung</th>
        <th>Bestätigung</th>
        <th>Abmeldung</th>
        <th>Aktiv?</th>
    </tr>
<?php
foreach ($recipients as $recipient):
    ?>
    <tr data-recipientuid="<?= $recipient->uniqueid() ?>" id="recipient-<?= $recipient->ID() ?>">
        <td title="<?= $recipient->ID() ?>"><?= $recipient->ID() ?></td>
        <td title="<?= $recipient->email() ?>"><?= $recipient->email() ?></td>
        <td title="<?= $recipient->fax() ?>"><?= $recipient->fax() ?></td>
        <td><?= DateTime::createFromFormat('U', $recipient->datum())->format('d.m.Y'); ?></td>
        <td><?= DateTime::createFromFormat('U', $recipient->date_confirmed())->format('d.m.Y'); ?></td>
        <td><?= DateTime::createFromFormat('U', $recipient->date_unregister())->format('d.m.Y'); ?></td>
        <td><?= boolval($recipient->bestaetigt()) ? '<i class="icon fa fa-check" style="color:greenyellow; cursor:pointer;"></i>' : '<i class="icon fa fa-times" style="color:red; cursor:pointer;"></i>' ?></td>
    </tr>
<?php
endforeach;
?>
</table>

<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            Allianz: <?= $alliance->alliance_name ?> <span class="label label-alliance"><?=$alliance->alliance_tag?></span>
        </div>

        <div class="panel-body">

            <table class="table table-bordered" id="alliance-member">
                <thead>
                <tr>
                    <th>Platz</th>
                    <th>Spieler</th>
                    <th>Planetenpunkte</th>
                    <th>Forschungspunkte</th>
                    <th>Gesamtpunkte</th>
                    <th>Planeten</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($data as $item) : ?>
                    <tr>
                        <td class="text-right"><?= $item->place ?></td>
                        <td class="text-center">
                            <a data-toggle="modal" data-target="#playerModal" data-player-id="<?= $item->player_id ?>"><?= $item->player_name ?></a>
                        </td>
                        <td class="text-right"><?= $item->points_planets ?></td>
                        <td class="text-right"><?= $item->points_research ?></td>
                        <td class="text-right"><?= $item->points_sum ?></td>
                        <td class="text-right"><?= $item->planets ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        var modal = $('#allianceModal');
        var table = $('#alliance-member');

        $(table).DataTable(gwstat.conf.dataTablesOptions);

        $(modal).find('a[data-toggle="modal"]').click(function() {
            $(modal).modal('hide');
        });

        $('#allianceModal-title').html('Allianz: <?= $alliance->alliance_name ?> [<?=$alliance->alliance_tag?>]');
    });
</script>
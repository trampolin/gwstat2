<div class="wrapper wrapper-content">

    <div class="panel panel-primary">
        <div class="panel-heading">
            Highscore
        </div>

        <div class="panel-body">

            <table class="table table-bordered" id="highscore">
                <thead>
                <tr>

                    <th>Spieler</th>
                    <th>Planetenpunkte</th>
                    <th>Forschungspunkte</th>
                    <th>Gesamtpunkte</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($highscore as $item) : ?>
                    <tr>
                        <td class="text-center">
                            <a data-player-id="<?= $item->player_id ?>" data-toggle="modal" data-target="#playerModal"><?= $item->player_name ?></a>
                            <?php if($item->alliance_tag !== '') : ?>
                                <?= getAllianceLabel($item->alliance_id,$item->alliance_tag) ?>
                            <?php endif ?>
                        </td>
                        <td class="text-right"><?= $item->points_planets ?></td>
                        <td class="text-right"><?= $item->points_research ?></td>
                        <td class="text-right"><?= $item->points_sum ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        //$('#highscore').DataTable(gwstat.conf.dataTablesOptions);
    });
</script>
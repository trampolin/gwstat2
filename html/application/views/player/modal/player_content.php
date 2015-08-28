<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= $data->player_name ?>

            <?php if ($data->alliance_tag !== '') : ?>
                <?= getAllianceLabel($data->alliance_id,$data->alliance_tag) ?>
            <?php endif ?>
        </div>
        <div class="panel-body">

            <table class="table table-bordered" id="highscore-progress">
                <thead>
                <tr>
                    <th>Stand</th>
                    <th>Platz</th>
                    <th>Spieler/Allianz</th>
                    <th>Planetenpunkte</th>
                    <th>Forschungspunkte</th>
                    <th>Gesamtpunkte</th>
                    <th>Planeten</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($progress as $item) : ?>
                    <tr>
                        <td><?= $item->capture_first ?></td>
                        <td class="text-right"><?= $item->place ?></td>
                        <td class="text-center">
                            <span data-player-id="<?= $item->player_id ?>"><?= $item->player_name ?></span>
                            <?php if($item->alliance_tag !== '') : ?>
                                <?= getAllianceLabel($item->alliance_id,$item->alliance_tag) ?>
                            <?php endif ?>
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

        var modal = $('#playerModal');
        var table = $('#highscore-progress');

        $(table).DataTable({
            bSort: false,
            searchHighlight: true
        });

        $(modal).find('.label-alliance').click(function() {
            $(modal).modal('hide');
        });

        $('#playerModal-title').html('Spieler: <?= $data->player_name ?>');
    });
</script>
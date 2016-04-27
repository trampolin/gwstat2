<div class="wrapper wrapper-content">

    <div class="row">

        <div class="col-md-4 col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Planeten
                </div>

                <div class="panel-body">
                    <div class="row">
                    <?php foreach ($planets as $planet => $active) { ?>
                        <div class="planet-p"><a<?= $active == 'selected' ? ' class="label label-primary"' : ' class="label label-default" href="'.base_url().'gw/changeActivePlanet/'.$planet.'" ' ?>><?= $planet ?></a> <a href="<?= base_url().'gw/shipSave/'.$planet ?>" class="label label-warning pull-right">Saven</a></div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Aktionen
                </div>

                <div class="panel-body">
                    <p><span id="parse-highscore" class="btn btn-warning full-width">Highscore erfassen</span></p>
                    <p><a href="<?= base_url().'gw/logout' ?>" class="btn btn-danger full-width">Logout</a></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Infos
                </div>

                <div class="panel-body">
                    <div class="row">
                    <?php foreach ($ress as $item) { ?>
                        <div class="col-xs-6">
                            <?= $item['type'] ?>: <?= $item['ress'] ?> (<?= $item['prod'] ?>/h)
                        </div>
                        <?php //var_dump($item) ?>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Log
                </div>

                <div class="panel-body" id="log">

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#parse-highscore').click(function() {
            $.ajax(gwstat.baseUrl+'gw/gethighscore')
                .success(function(response) {
                    $('#log').html(response);
                }).error(function(a,b,c) {
                    $('#log').html(a.responseText);
                });
        });
    });
</script>
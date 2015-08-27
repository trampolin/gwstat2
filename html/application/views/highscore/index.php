<div class="wrapper wrapper-content">




    <div class="panel panel-primary">
        <div class="panel-heading">
            Highscore
        </div>

        <div class="panel-body">

            <table class="table table-bordered">
                <thead>

                </thead>

                <tbody>
                    <?php foreach($highscore as $item) : ?>
                    <tr>
                        <?php foreach($item as $td) : ?>
                            <td><?= $td ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>



</div>
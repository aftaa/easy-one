<link rel="stylesheet" type="text/css" href="/css/easy/debug.css">
<div id="debug-bottom">
<ul>
    <li>
        <a data-href="debug-bottom-container">Service Container</a>
        <div id="debug-bottom-container" class="debug-bottom-sub">
            <?php
            echo '<h2 >Container</h2><pre>';
            print_r(\easy\Application::$serviceContainer->getInstances());
            echo '</pre>';
            ?>
        </div>
    </li>
    <li>
        <a data-href="debug-bottom-queries">Queries</a>
        <div id="debug-bottom-queries" class="debug-bottom-sub">
            <?php
            /** @var \easy\helpers\QueryTimes $queryTimes */
            $queryTimes = \easy\Application::$serviceContainer->get(\easy\helpers\QueryTimes::class);
            if ($queryTimes) {
            ?>
            <h4>Queries: <?= count($queryTimes->get()) ?> in <?= $queryTimes->timeSum ?>sec.</h4>
            <table class="table>">
                <thead>
                <tr>
                    <th>Query</th>
                    <th>Params</th>
                    <th>Time</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($queryTimes->get() as $item): /** @var $item \easy\helpers\QueryTimesItem */ ?>
                    <tr>
                        <td><?= $item->getSQL() ?></td>
                        <td>
                            <?php foreach ($item->getParams() as $name => $value): ?>
                                [<?= $name ?> => <?= $value ?>]
                            <?php endforeach ?>
                        </td>
                        <td><?= $item->getTime() ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
            <?php } else { echo 'No queries yet'; } ?>
        </div>
    </li>
    <li>
        <a data-href="debug-bottom-routes">Routes</a>
        <div id="debug-bottom-routes" class="debug-bottom-sub">
            <?= \easy\Application::$serviceContainer->init(\easy\basic\router\HtmlDebug::class)->debug() ?>
        </div>
    </li>
</ul>
</div>

<script src="/js/jquery.js"></script>
<script type="text/javascript">
    $('#debug-bottom a').on('click', function () {
        $('div.debug-bottom-sub').fadeOut('slow');
        let id = $(this).data('href');
        $('#' + id).toggle();
    });
</script>
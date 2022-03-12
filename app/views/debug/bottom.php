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
            <?php $queryTimes = \easy\Application::$serviceContainer->init(\easy\helpers\QueryTimes::class) ?>
            <?php if ($queryTimes && $queryTimes->get()): ?>
            <?php foreach ($queryTimes->get() as $time): ?>
            <?= $item->getSQL ?>
            <?php endforeach ?>
            <?php endif ?>
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
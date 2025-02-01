<?php

function produceNote($noteContext)
{
    $content = $noteContext['content'];
    $date = $noteContext['date'];

    $noteHtml = <<<HTML
    <div class="block">
        <p><small>$date</small></p>
        <p>$content</p>
    </div>
HTML;

    echo $noteHtml;
}

<?php

function produceNote($noteContext)
{
    $content = $noteContext['content'];
    $date = $noteContext['date'];

    $noteHtml = <<<HTML
    <div class="block">
        <p>$content</p>
        <p><small>$date</small></p>
    </div>
HTML;

    echo $noteHtml;
}

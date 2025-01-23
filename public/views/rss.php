<?php

header("Content-Type: application/rss+xml; charset=utf-8");

echo <<<XML
<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>A Personal Journey</title>
    <subtitle>By Koehn Humphries</subtitle>
    <link type="application/atom+xml" href="https://koehn.lol/feed.xml" />
    <rights>Copyright © 2025, Koehn Humphries</rights>
    <updated>2025-01-22T01:09:30Z</updated>
    <id>https://koehn.lol/</id>
XML;
echo "\n";

$filteredPosts = array_filter($posts, function ($post) {
    return $post["status"] == "published";
});

foreach ($filteredPosts as $post_slug => $post_data) {
    echo <<<XML
        <entry>
            <link rel='alternate' type='text/html' href="https://koehn.lol/post/$post_data[slug]"/>
            <id>https://koehn.lol/post/$post_data[slug]</id>
            <title>$post_data[title]</title>
            <published>$post_data[pub_at]</published>
            <updated>$post_data[upd_at]</updated>
            <author>
                <name>Koehn Humphries</name>
                <uri>https://koehn.lol/</uri>
            </author>
            <summary type='text'>$post_data[description]</summary>
            <content type='html' xml:base='https://koehn.lol/' xml:lang='en'>
                <![CDATA[{$parser->parse($post_data["content"])}]]>
            </content>
        </entry>
    XML;
    echo "\n";
}
;

echo "</feed>\n<!-- THE END -->";
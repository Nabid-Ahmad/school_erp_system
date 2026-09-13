<?php
$content = file_get_contents('resources/views/welcome.blade.php');
$lines = explode("\n", $content);
$stack = [];
foreach($lines as $i => $line) {
    if (preg_match_all('/@(if|forelse|foreach|while|for|auth|guest|can|canany|isset|empty)\b/', $line, $matches)) {
        foreach($matches[1] as $m) $stack[] = ['type' => $m, 'line' => $i+1];
    }
    if (preg_match_all('/@(endif|endforelse|endforeach|endwhile|endfor|endauth|endguest|endcan|endcanany|endisset|endempty)\b/', $line, $matches)) {
        foreach($matches[1] as $m) array_pop($stack);
    }
}
print_r($stack);
